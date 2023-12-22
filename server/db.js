const Pool = require("pg").Pool;

const pool = new Pool({
    user: "postgres",
    password: "post123",
    host: "localhost",
    port: 5432,
    database: "TripPlanner"
})

module.exports = pool;