# RateGuard PHP Extension

RateGuard is a powerful PHP extension designed to effortlessly implement rate limiting functionality in your web applications. With RateGuard, you can efficiently control the rate of incoming requests, safeguard against abuse, and ensure optimal performance.

## Table of Contents

- [Introduction](#introduction)
- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Example](#example)
- [Configuration](#configuration)
- [Contributing](#contributing)
- [License](#license)

## Introduction

Rate limiting is a crucial aspect of web development, enabling you to protect your applications from various types of attacks, including brute force attacks, denial-of-service (DoS) attacks, and API abuse. RateGuard leverages the power of Redis, a high-performance, in-memory data store, to provide efficient and reliable rate limiting capabilities.

## Features

- **Simple Integration**: Easily integrate RateGuard into your PHP applications with minimal setup.
- **Flexible Configuration**: Customize rate limiting parameters such as request limit, time duration, and Redis settings.
- **Efficient Storage**: Utilizes Redis to efficiently store and manage request counts and expiration times.
- **Protects Against Abuse**: Safeguard your application from abuse, unauthorized access, and potential security threats.
- **Enhances Performance**: Maintain optimal performance by controlling traffic and preventing resource exhaustion.

## Installation

To get started with RateGuard, follow these simple steps:

1. **Install Redis**: Ensure you have Redis installed and running on your server. You can download Redis from the [official website](https://redis.io/download).

2. **Install RateGuard**: Include the `RateGuard.php` file in your PHP project.

3. **Configure Redis**: Connect to your Redis server in the RateGuard constructor by passing an instance of the Redis client.

4. **Initialize RateGuard**: Create a new instance of the `RateGuard` class, passing the Redis client instance.

## Usage

Once RateGuard is integrated into your application, you can use it to enforce rate limits by calling the `check()` method with the desired limit. If the number of requests exceeds the limit, further requests will be denied.

```php
require_once('RateGuard.php');

// Connect to Redis
$redis = new Redis();
$redis->connect('127.0.0.1', 1234);
$redis->auth('your_password');

// Initialize RateGuard
$RateGuard = new RateGuard($redis);

// Check rate limit
if (!$RateGuard->check(5)) {
    die('TOO MANY REQUESTS FROM THE IP');
}

echo 'WOW!!!!!!!!';
```

## Example

Check out the `demo.php` file for a working example of how to use RateGuard in your PHP application.

## Configuration

### RateGuard.php

The `RateGuard.php` file contains the implementation of the RateGuard class, which is responsible for enforcing rate limits in your PHP application. You can customize the rate limiting behavior by modifying the parameters within this file according to your specific requirements.

#### Configuration Options

- **`$master_limit`**: The overall limit for the number of requests allowed within the specified duration. You can adjust this value to set the maximum number of requests permitted across all IPs and scripts.
  
- **`$database_index`**: The Redis database index used to store rate limiting data. By default, it's set to `5`, but you can change it if necessary.

- **`$duration`**: The duration (in milliseconds) for which the rate limit applies. Requests made within this duration are counted towards the limit. You can modify this value to set the time window for rate limiting.

### Customization

Feel free to modify the `RateGuard.php` file to tailor the rate limiting behavior to your application's needs. Adjust the parameters mentioned above and explore additional customization options to achieve the desired rate limiting strategy.

```php
class RateGuard {
    private $redis = null;
    private $master_limit = 30;
    private $database_index = 5;
    private $duration = 10000;
    
    // Constructor and methods omitted for brevity
}
```

## Contributing

Contributions are welcome! If you have any suggestions, bug reports, or feature requests, please feel free to open an issue or submit a pull request.

## License

RateGuard is licensed under the MIT License. See the [LICENSE](LICENSE) file for more information.
