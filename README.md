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

**目的**: 旅行のスケジュール管理を簡単にするためのツールです。仕事で世界中を移動することが多くいつも準備をする際にメモ帳や携帯アプリなどを使用していましたが、用途ごとに使用するツールが分かれることが悩みでした。そこで、自分の経験から特に必要な機能を一つにまとめてアプリにしてみようと思いました。ここでは、スケジュール管理、移動管理、宿泊施設管理、チェックリストを旅行別にまとめられるようになっています。旅行の必要な機能が、このアプリひとつで完結できるようになっています。
**ターゲットユーザー**: 国内・国外問わずに使用することができて、デジタルノマドや頻繁に移動するフリーランサーの他、ビジネス出張者や旅行者などが効率的に旅行プランを管理できるアプリです。

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

  **コア機能**: 旅行プランの作成、スケジュール管理、宿泊先と交通機関の予約管理、チェックリスト機能
  **追加機能**: Google Maps APIを使用して地図機能と住所検索を実装しています。ジオコーディングAPIを利用することで、ユーザーが入力した住所を地図上に表示し、モーダルを使用して詳細情報を表示しています。FullCalendarを使用して、ユーザーがイベントを簡単に管理できるインターフェースを提供しています。これにより、スケジュールの追加、編集、削除が直感的に行えます。

## Challenges and Solutions
- **Problem**: Initially, there were frequent errors when loading the Google Maps API asynchronously.
- **Solution**: Improved page loading speed and user experience by optimizing how asynchronous processes are handled.

**問題点**: 最初はGoogle Maps API を非同期で読み込むときにエラーが頻繁に発生していました。
**解決策**: 非同期プロセスの処理方法を調整することで、ページの読み込み速度が大幅に向上し、全体的なユーザー体験が向上しました。

## Future Plans
- Implement unit tests for core features using PHPUnit
- Explore deployment strategies and CI/CD processes
- Add new features like a memory log for past trips and a reminder system for scheduled tasks

**問題点**
- 機能の安定性を確保するために、PHPUnit を使用してコア機能の単体テストを実装します。
- CI/CD プロセスを実装するための展開戦略とホスティング サービスに関する専門知識を学び実装する。
- 過去の旅行の記録を残すメモリーログや、既存のスケジュールに基づいて重要なタスクを通知するリマインダーシステムなどの機能追加による機能拡張を予定しています。

## License
MyTrip-app is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
