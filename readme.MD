# Moodle Runtime Performance Benchmark

This project compares the performance of different PHP runtimes and web servers running Moodle in a Docker environment. We conducted benchmark tests to measure response times and request throughput under various load conditions.

## Testing Environment

- PHP Version: 8.2
- Base Images: Official Docker images for each runtime
- Container Setup:
  - Runtime Container (Apache/Nginx/FrankenPHP)
  - MySQL Container
  - K6 Container for load testing

### Tested Runtimes
- Apache + mod_PHP
- Apache + PHP-FPM
- Nginx + PHP-FPM
- Nginx Unit
- FrankenPHP

**Note:** Moodle does not officially support Nginx Unit & FrankenPHP. The setup was modified to force Moodle to run on these runtimes.

## Testing Methodology

### Application
- Fresh Moodle installation
- No additional plugins
- Moodle default configuration

### Load Testing Configuration
- Tool: K6
- Test Scenarios:
  - 10 concurrent users
  - 100 concurrent users
  - 1000 concurrent users
- Duration: 30 seconds per test

### Metrics Measured
- Average Response Time (ms)
- Requests per Second

## Performance Results

| Runtime | 10 Virtual Users |  | 100 Virtual Users |  | 1000 Virtual Users |  |
|---------|------------------|--|------------------|--|-------------------|--|
|         | Avg Resp (ms) | Req/Sec | Avg Resp (ms) | Req/Sec | Avg Resp (ms) | Req/Sec |
| Apache + mod_PHP | 122.89 | 81.13 | 1079.36 | 91.72 | 10393.32 | 56.49 |
| Apache + PHP-FPM | 127.18 | 78.36 | 1169.55 | 83.72 | 12940.65 | 52.26 |
| Nginx + PHP-FPM | 167.54 | 59.51 | 1203.49 | 81.38 | 10923.29 | 77.00 |
| Nginx Unit | 180.78 | 55.10 | 2231.72 | 43.27 | 15843.35 | 50.15 |
| FrankenPHP | 186.38 | 53.39 | 1711.77 | 57.19 | 13301.35 | 62.33 |

## Key Findings

- Apache setups (both mod_PHP and PHP-FPM) showed consistent performance, especially at lower concurrency levels
- Nginx + PHP-FPM maintained good stability and throughput across different loads
- Traditional server setups (Apache and Nginx with PHP-FPM) performed reliably for running Moodle in Docker

## Disclaimer

Note that these results are specific to our testing environment and might perform differently in other setups. We encourage you to test these configurations in your own environment to find what works best for your needs.

There may be areas we missed or aspects that could be improved. We welcome any feedback and discussion!