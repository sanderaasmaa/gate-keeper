# Gate Keeper

## Overview
<ul>
<li><img src="https://imgur.com/0uz8ZXt.png"></li>
<li><img src="https://imgur.com/6lmUZLf.png"></li>
<li><img src="https://imgur.com/jnGgsaB.png"></li>
<li><img src="https://imgur.com/cfvxYtc.png"></li>
<li><img src="https://imgur.com/3I5BZUd.png"></li>
<li><img src="https://imgur.com/cWssS2S.png"></li>
</ul>

## Installation
- `git clone https://github.com/sanderaasmaa/gate-keeper.git`
- `cd gate-keeper`
- `composer install`
- copy & rename `.env.example` to `.env`
- update `.env` with database credentials and timezone
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan key:generate`
- `php artisan db:seed`
- `yarn install`
- `yarn watch`

## Available api calls

- `GET` - `example.com/services` - List all services and service passes
- `POST` - `example.com/services/create` - Create new service 
`{
    name: 'foo'
}`
- `POST` - `example.com/service/{serviceId}/passes/create` - Create new service pass. 0 for infinite turns.
`{
    name: 'foo 10 days', 
    expiry_days: '10',
    repetitions: '0'
}`

- `GET` - `example.com/customer/{customerId}/access/{serviceId}` - Check if user has access to service
- `PATCH` - `example.com/customer/{customerId}/access/{serviceId}` - Check if user has access to service, if so, use this service

- `GET` - `example.com/customers` - List of customers
- `POST` - `example.com/assign` - Assign service pass to customer
`{
    customer: '1', 
    pass: '2'
}`
