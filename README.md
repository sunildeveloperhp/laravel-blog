# Laravel Blog

A multi-author blogging platform built with Laravel 13, Blade and Tailwind CSS.
Authors write and manage their own posts, readers comment, and admins moderate everything from an admin panel.
The same app also serves a versioned REST API (`/api/v1`) with Sanctum token authentication.

## Features

**Public site**
- Home page with the latest posts
- Posts list with search, category filter and pagination
- Single post pages with featured image, tags and comments
- Category, tag and author pages
- Contact form that emails all admins

**Accounts**
- Register, log in, log out, "remember me"
- Email verification
- Forgot password / reset password by email
- Profile page: change name, email and password

**Authors**
- Dashboard with "My Posts"
- Create, edit and delete posts with featured image upload and tags
- Unique SEO-friendly slugs, soft deletes
- Email + in-app notification when a comment on their post is approved

**Admins**
- Admin panel with site statistics
- Manage users and their roles (Admin, Author, Reader)
- Manage all posts, categories and tags
- Comment moderation (approve / delete)

## Tech highlights

- Eloquent relationships: belongsTo, hasMany, many-to-many (tags) with a pivot table
- Route model binding with slugs, resource controllers, query scopes, accessors
- Form Request validation, flash messages, custom error pages (403, 419)
- Authentication built by hand (no starter kit): sessions, password hashing, signed verification links
- Authorization with a Policy (owner-only edit/delete, admin bypass), a Gate and custom middleware
- Role stored as a PHP backed enum
- Service classes (`PostService`, `CommentService`) shared by the website and the API
- Mail and database notifications, a Mailable for the contact form
- Queued notifications and mail, events and listeners
- Rate limiting on login, comments, contact form and verification emails
- N+1 protection with eager loading and `Model::preventLazyLoading()`
- Versioned REST API with API Resources, Sanctum tokens and clean JSON errors

## Requirements

- PHP 8.3+
- Composer
- Node.js and npm
- MySQL

## Installation

```bash
git clone https://github.com/sunildeveloperhp/laravel-blog.git blog
cd blog

composer install
npm install

cp .env.example .env
php artisan key:generate
```

Create a MySQL database, then set these values in `.env`:

```env
APP_URL=http://blog.test

DB_CONNECTION=mysql
DB_DATABASE=blog
DB_USERNAME=root
DB_PASSWORD=

QUEUE_CONNECTION=database
```

For local email testing, point the mailer at Mailpit (or any SMTP server):

```env
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
```

Then build the database and assets:

```bash
php artisan migrate --seed
php artisan storage:link
npm run build
```

Emails and notifications are sent through the queue, so keep a worker running:

```bash
php artisan queue:work
```

## Demo accounts

| Role  | Email               | Password |
|-------|---------------------|----------|
| Admin | admin@example.com   | password |

The seeder also creates 4 author accounts with random emails (password: `password`). You can see their emails in **Admin → Users**.

## REST API (v1)

The same app also serves a JSON API at `/api/v1`, used by the Next.js frontend.
A ready-made Postman collection with examples is in [`docs/postman/`](docs/postman/laravel-blog-api.postman_collection.json).

### Authentication

Log in to get a Sanctum token, then send it with every protected request:

```http
POST /api/v1/login
Content-Type: application/json
Accept: application/json

{ "email": "admin@example.com", "password": "password", "device_name": "my-app" }
```

```http
Authorization: Bearer <token>
Accept: application/json
```

### Endpoints

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/api/v1/posts` | – | Published posts. Query: `q`, `category`, `page` |
| GET | `/api/v1/posts/{slug}` | – | Single post with body, author, category, tags |
| GET | `/api/v1/posts/{slug}/comments` | – | Approved comments |
| GET | `/api/v1/categories` | – | Categories with post counts |
| GET | `/api/v1/tags` | – | Tags with post counts |
| POST | `/api/v1/register` | – | Create an account, returns a token |
| POST | `/api/v1/login` | – | Returns a token |
| POST | `/api/v1/logout` | Token | Revokes the current token |
| GET | `/api/v1/user` | Token | The logged-in user's account |
| GET | `/api/v1/my/posts` | Token + verified | The user's own posts, including drafts |
| POST | `/api/v1/posts` | Token + verified | Create a post (authors and admins) |
| PUT | `/api/v1/posts/{slug}` | Token + verified | Update a post (owner or admin) |
| DELETE | `/api/v1/posts/{slug}` | Token + verified | Move a post to the trash (owner or admin) |
| POST | `/api/v1/posts/{slug}/comments` | Token + verified | Add a comment (pending until approved, unless admin) |

### Errors

Every error has a `message`. Validation errors (`422`) also include `errors`, with a list of messages per field.
Status codes used: `200`, `201`, `204`, `401`, `403`, `404`, `405`, `422`, `429`.

## Roadmap

- [x] Blog web app v1
- [x] REST API with Laravel Sanctum
- [ ] Queues, caching and tests
- [ ] Next.js frontend
