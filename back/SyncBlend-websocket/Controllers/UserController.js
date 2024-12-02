class UserController {
    static getHello(req, res) {
        res.send({id:1, name:"JUAN"});
    }
}

module.exports = UserController;