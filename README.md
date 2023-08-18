# HydraPHP - Habbo Emulator

<img src="https://i.imgur.com/J18nIKo.png" />

#### An emulator for Habbo servers made in PHP. In order to learn how to build concurrent applications using threads and memory management.

**PS**: This will never be a production project, so don't try to use this in your hotel. This project is for learning only!

## Requirements

- PHP ^8.1

## Installation and Running

```cmd
git clone https://github.com/nicollassilva/hydraphp
cd hydraphp
composer install
```

Configure the **config.json** file and run the emulator with:

- Windows with **Windows Terminal**:
```cmd
./start.bat
```

- Linux:
```cmd
bin\sh ./start.sh
```

Or if none of the above work, run directly via **PHP**:

```cmd
php bootstrap.php
```

**PS**: The emulator only works with **SWF**. So it doesn't support **Nitro HTML5 version**.

## TODO:

- [x] Parse the configuration file and get all emulator settings via MySQL
- [x] Create a TCP server with client management
- [x] Parse incoming/outgoing packets
- [x] Create a MySQL connection handler
- [x] Create a Cross-Domain Policy handler
- [x] Login with real user data (via MySQL)
- [x] List all rooms in the navigator (publics, populars, and my rooms)
- [x] Enter and exit a room
- [x] Room chat with bubble types
- [x] Room movement (pathfinding)
- [x] Search rooms in the navigator
- [x] List all catalog pages/items
- [x] Load all placed items in the room
- [x] Create a room
- [ ] **WIP**: Room item placement/movement/interaction
- [ ] Buy catalog items
- [ ] Save room data in MySQL
- [ ] Create a Nitro connection handler (HTML5 client)

## Discover the Orion project

- [OrionCMS - Modern and secure CMS for Arcturus Emulator made in Laravel 10+ and AlpineJS.](https://github.com/nicollassilva/orioncms)