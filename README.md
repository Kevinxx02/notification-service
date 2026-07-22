# Notification Service

A production-oriented Notification Microservice built with **Laravel 13**, **PHP 8.3**, **RabbitMQ**, **Docker**, **Domain-Driven Design (DDD)** and **Hexagonal Architecture**.

The service is responsible for processing asynchronous notification requests received through RabbitMQ and delivering transactional emails via SMTP.

This project focuses on software architecture, maintainability, code quality and asynchronous communication between microservices rather than exposing a traditional HTTP API.

---

# Features

* Asynchronous message consumption using RabbitMQ
* Transactional email delivery via SMTP
* Domain-Driven Design (DDD)
* Hexagonal Architecture (Ports & Adapters)
* Dependency Inversion Principle (DIP)
* SOLID Principles
* Immutable Value Objects
* Dockerized development environment
* Static analysis with PHPStan
* Code style enforcement with Laravel Pint
* Composer Security Audit
* GitHub Actions Continuous Integration
* PHPUnit
* Mutation Testing (Infection)

---

# Architecture

```
Producer Service
        │
        ▼
    RabbitMQ
        │
        ▼
Rabbit Consumer Command
        │
        ▼
SendNotificationHandler
        │
        ▼
Notification Entity
        │
        ▼
NotificationSender (Output Port)
        │
        ▼
SMTP Adapter
        │
        ▼
SMTP Server
```

The application follows a strict separation of responsibilities.

* Application layer coordinates use cases.
* Domain layer contains all business rules.
* Infrastructure contains framework and external integrations.

The Domain remains completely independent from Laravel, RabbitMQ and SMTP.

---

# Project Structure

```
app
├── Application
│   ├── Ports
│   │   ├── In
│   │   └── Out
│   └── SendNotification
│
├── Console
│
├── Domain
│   ├── Entities
│   ├── ValueObjects
│   └── Exceptions
│
└── Infrastructure
    ├── Notification
    └── RabbitMQ
```

---

# Workflow

1. Another microservice publishes a notification event.
2. RabbitMQ stores the message.
3. The Notification Service consumes the message.
4. The Use Case validates the request.
5. Domain Objects are created.
6. The SMTP Adapter sends the email.
7. RabbitMQ receives an ACK confirming successful processing.

---

# Technologies

* PHP 8.3
* Laravel 13
* RabbitMQ
* Docker
* Composer
* PHPUnit
* PHPStan
* Laravel Pint
* Infection
* GitHub Actions

---

# Quality Standards

Every Pull Request executes:

* Composer Security Audit
* Laravel Pint
* PHPStan
* PHPUnit
* Mutation Testing

Only code that passes every quality gate can be merged.

---

# Design Principles

* Domain-Driven Design
* Hexagonal Architecture
* Repository Pattern (when persistence is required)
* Dependency Injection
* Ports and Adapters
* SOLID
* Clean Code

---

# Local Development

```bash
docker compose up --build -d
```

Run the RabbitMQ consumer:

```bash
php artisan rabbit:consume
```

Run static analysis:

```bash
./vendor/bin/phpstan analyse
```

Run code style checks:

```bash
./vendor/bin/pint --test
```

Run tests:

```bash
php artisan test
```

Run mutation testing:

```bash
vendor/bin/infection
```

---

# Future Improvements

* Retry queues
* Dead Letter Queue (DLQ)
* Exponential Backoff
* Idempotent Message Processing
* Correlation IDs
* Distributed Tracing
* Metrics and Monitoring
* Structured Logging
* Email Templates
* Multi-provider SMTP support
* Rate limiting
* OpenTelemetry integration

---

# Purpose

This project is intended as a production-style backend microservice demonstrating asynchronous communication, software architecture and modern backend engineering practices.
