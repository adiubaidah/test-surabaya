## API Endpoints

### Authentication
- `aksamedia-api.adiiskandar.my.id/login`

After login, you will get the cookie, and you can access divisions and employee

###
- `aksamedia-api.adiiskandar.my.id/divisions`

### Employees

#### GET
- `aksamedia-api.adiiskandar.my.id/employees`

#### POST
- `aksamedia-api.adiiskandar.my.id/employees`

  **Body:**
  - `name`
  - `phone`
  - `division_id`
  - `position`
  - `image`

#### PUT
- `aksamedia-api.adiiskandar.my.id/employees/{uuid}`

  **Body:**
  - `name`
  - `phone`
  - `division_id`
  - `position`
  - `image`

#### DELETE
- `aksamedia-api.adiiskandar.my.id/employees/{uuid}`

### Bonus

- `aksamedia-api.adiiskandar.my.id/nilaiST`
- `aksamedia-api.adiiskandar.my.id/nilaiRT`