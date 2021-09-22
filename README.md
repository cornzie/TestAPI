

## About This Project

This is a sample REST API written with Laravel.


## Endpoints

# Both
- /api/login
- - Body
email
password

- /api/register
- - Body
- - - name
- - - email
- - - mobile
- - - office_address
- - - password
- - - password_confirmation
- - - type
- - - user_id


# Employer
- /api/verify
- - Body
- - - otp
- /api/transactions ( TODO: Add balances and better relationships)
- - Body

# Employee
- /api/employeeVerify
- - Body
- - - otp

# Utils
- /api/employers
- /api/employers/1
- /api/employees
- /api/employees/1

## Headers

- Content-Type: application/x-www-form-urlencoded
- Accept: application/json
- Authorisation: Bearer token

## Packages
- Sanctum

## To Dos:
- Implement a response formating trait
- Write tests
