class UserManager {
    constructor(user = null) {
        this._user = user;
    }

    setUser(user) {
        this._user = user;
    }

    getUser() {
        return this._user;
    }
}

export default new UserManager();
