<?php

namespace Emulator\Networking\Packages;

use Emulator\Hydra;
use Emulator\Utils\Logger;
use Emulator\Api\Networking\Connections\IClient;
use Emulator\Api\Networking\Packages\IPackageManager;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Utils\Services\EncodingService;

class PackageManager implements IPackageManager
{
    private readonly Logger $logger;
    private readonly IncomingPackagesLoader $incomingPackagesLoader;

    public function __construct(
        private readonly string $crossDomainPolicy = '<?xml version="1.0"?><!DOCTYPE cross-domain-policy SYSTEM "/xml/dtds/cross-domain-policy.dtd"><cross-domain-policy><allow-access-from domain="*" to-ports="*" /></cross-domain-policy>'
    ) {
        $this->logger = new Logger(get_class($this));
        $this->incomingPackagesLoader = new IncomingPackagesLoader();
    }
    
    public function handle(mixed $data, IClient $client): void
    {
        if(str_starts_with($data, '<')) {
            $this->handleCrossDomainPolicy($client);
            return;
        }

        foreach ($this->handleBuffer($data) as $package) {
            $this->handlePackage($client, new ClientMessage($package));
        }
    }

    private function handleBuffer(mixed $data): array
    {
        $groupedPackages = [];

        while (strlen($data) > 3) {
            $length = EncodingService::decodeInteger($data) + 4;
            $groupedPackages[] = substr($data, 0, $length);
            $data = substr($data, $length);
        }

        return $groupedPackages;
    }

    private function handlePackage(IClient $client, ClientMessage $message): void
    {
        if(empty($client)) return;

        if($package = $this->incomingPackagesLoader->getPackageByHeader($message->getHeader())) {
            if(Hydra::$isDebugging) $this->logger->info(sprintf('[I] [%s] %s', $message->getHeader(), $package));

            $package = new $package();

            if($package->needsAuthentication() && (!$client->getUser() || $client->getUser()->isDisposed())) {
                $this->logger->warning(sprintf('[%s] %s', $message->getHeader(), "Package needs authentication"));
                $client->disconnect();
                return;
            }

            $package->handle($client, $message);
        } else {
            if(Hydra::$isDebugging) $this->logger->warning(sprintf('[%s] %s', $message->getHeader(), "Unhandled package"));
        }
    }

    private function handleCrossDomainPolicy(IClient $client): void
    {
        $client->getConnection()->write($this->crossDomainPolicy);
        $client->getConnection()->end();
    }
}