import BaseModel from 'models/BaseModel';
import AccountModel from 'models/AccountModel';

const UserModel = BaseModel.extend({
    url: '/user',

    name: 'User',

    getAccount() {
        return new AccountModel();
    },
});

export default UserModel;
