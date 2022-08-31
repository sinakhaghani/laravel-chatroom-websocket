# laravel-chatroom-websocket
This is an online chat room sample project in Laravel using websockets.

## Installation and Setup

Clone this repository by running
```bash
 git clone https://github.com/sinakhaghani/laravel-websocket-chatroom.git
```
Install the packages by running the composer install command
```bash
 composer install
```

Install JavaScript dependencies
```bash
 npm install
```

Set your database credentials in the `.env` file

Run the migrations
```bash
 php artisan migrate
```

### Pusher
Set the Pusher app credentials in the `.env` as follows
```
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=mt1
```
Set the `BROADCAST_DRIVER` variable in the `.env` file to `pusher`
```base
BROADCAST_DRIVER=pusher
```

Run the laravel
```bash
 php artisan serve
```

Run the [websockets](https://beyondco.de/docs/laravel-websockets/getting-started/introduction)
```bash
 php artisan websocket:serve
```

Go to the following url and connect websockets
```base
localhost:8000/laravel-websockets
```

Now the project is ready to use
```base
localhost:8000/rooms
```
