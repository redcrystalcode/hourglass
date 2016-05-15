import BaseError from 'errors/BaseError';

class ModelNotLoadedError extends BaseError {
    constructor(model) {
        super(`${model} has not been fetched yet. You must call \`model.fetch()\` before calling this method.`);
    }
}

export default ModelNotLoadedError;
