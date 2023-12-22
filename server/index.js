const express = require("express"); //"express é a library"
const app = express();
const cors = require("cors");
const pool = require("./db");

//middleware (no meio do processo todo)
app.use(cors())
app.use(express.json()); //req.body

//!!! Routes (CRUD) !!!//

//Create user
//async provides with the function await which waits for the function to complete before it continues

app.post("/users", async(req,res) => {
    try {
        const { username, email, password } = req.body;
        const newUser = await pool.query(
            "INSERT INTO users (username, email, password) VALUES ($1, $2, $3) RETURNING *",
        [username, email, password]);

        res.json(newUser.rows[0]);
    } catch (err) {
        console.error(err.message);
        res.status(500).send("Erro com o servidor");
    }
});

//get all users

app.get("/users", async (req, res) => {
    try {
        const allUsers = await pool.query(
            "SELECT * FROM users");

        res.json(allUsers.rows);
    } catch (err) {
        console.error(err.message);
        res.status(500).send("Erro com o servidor");
    }
});

//get a specific user
//:id especifica o user que queremos obter
app.get("/users/:id", async (req, res) => {
    try {
        const { id } = req.params;
        const user = await pool.query(
            "SELECT * FROM users WHERE user_id = $1", 
        [id]);

        res.json(user.rows[0]);
    } catch (err) {
        console.error(err.message);
        res.status(500).send("Erro com o servidor");
    }
});

//update a user (put é para update)

app.put("/users/:id", async (req, res) => {
    try {
        const { id } = req.params;
        const { username, email, password } = req.body;

        const updatedUser = await pool.query(
            "UPDATE users SET username = $1, email = $2, password = $3 WHERE user_id = $4 RETURNING *",
            [username, email, password, id]);

        res.json(updatedUser.rows[0]);
    } catch (err) {
        console.error(err.message);
        res.status(500).send("Erro com o servidor");
    }
});

//delete a user

app.delete("/users/:id", async (req, res) => {
    try {
        const { id } = req.params;
        await pool.query(
            "DELETE FROM users WHERE user_id = $1",
            [id]);

        res.json("User deleted");
    } catch (err) {
        console.error(err.message);
        res.status(500).send("Erro com o servidor");
    }
});

//Para o server começar temos de dar listen à port do server 
//(5000 é a porta neste caso o parentesis ()
// é o host name e o console.log é a callback function para nos indicar que começou com sucesso)

app.listen(5000, () => {
    console.log("O servidor começou no port: 5000");
});