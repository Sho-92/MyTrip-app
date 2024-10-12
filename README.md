<p align="center"><a href="https://mytrip-app.com" target="_blank"><img src="https://github.com/Sho-92/MyTrip-app/blob/main/public/images/logo.png?raw=true" width="400" alt="MyTrip-app Logo"></a></p>


<p align="center">
<a href="https://github.com/mytrip-app/actions"><img src="https://github.com/mytrip-app/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/mytrip-app/framework"><img src="https://img.shields.io/packagist/dt/mytrip-app/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/mytrip-app/framework"><img src="https://img.shields.io/packagist/v/mytrip-app/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/mytrip-app/framework"><img src="https://img.shields.io/packagist/l/mytrip-app/framework" alt="License"></a>
</p>

# MyTrip-app

## Web Application Overview

**Purpose**: MyTrip-app is a tool designed to simplify travel schedule management. It allows users to organize their trips by managing schedules, transportation, accommodation, and checklists, all categorized by each trip. The aim is to consolidate all necessary travel management features into one platform for digital nomads, frequent travelers, and business professionals.

**Target Users**: Digital nomads, freelancers, business professionals, and anyone who needs to manage travel plans efficiently, both domestically and internationally.

## Technologies Used

- **Frontend**: HTML5, Bootstrap5, Bootstrap Icons, FontAwesome6, FullCalendar, JavaScript
- **Backend**: Laravel 11, SQLite
- **API Integration**: Google Maps API

## Key Features

- **Core Features**: 
  - Creation of travel plans
  - Schedule management
  - Booking management for accommodations and transportation
  - Checklist functionality
- **Additional Features**: 
  - Mapping and address search powered by Google Maps API
  - Geocoding API for displaying addresses on maps
  - FullCalendar for intuitive event management, including adding, editing, and deleting schedules.

## Challenges and Solutions

- **Problem**: Initially, there were frequent errors when loading the Google Maps API asynchronously.
- **Solution**: Improved page loading speed and user experience by optimizing how asynchronous processes are handled.

## Future Plans

- Implement unit tests for core features using PHPUnit
- Explore deployment strategies and CI/CD processes
- Add new features like a memory log for past trips and a reminder system for scheduled tasks

## License

MyTrip-app is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
