class UserController {
    static getHello(req, res) {
        res.send({id:1, name:"JUAN"});
    }

    static loadData (req, res){
        
    }
}

module.exports = UserController;