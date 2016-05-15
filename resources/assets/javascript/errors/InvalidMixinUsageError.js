import BaseError from 'errors/BaseError';

class InvalidMixinUsageError extends BaseError {
    /**
     *
     * @param {string} mixin
     * @param {string} depends
     */
    constructor(mixin, depends) {
        super(`${mixin} cannot be used on this class. It depends on ${depends}.`);
    }
}

export default InvalidMixinUsageError;
