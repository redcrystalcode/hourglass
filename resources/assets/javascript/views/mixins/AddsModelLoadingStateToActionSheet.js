const AddsModelLoadingStateToActionSheet = {
    initialize() {
        this.listenTo(this.model, 'request', this.addLoadingState);
        this.listenTo(this.model, 'sync', this.removeLoadingState);
        this.listenTo(this.model, 'error', this.removeLoadingState);
    },
    addLoadingState() {
        this.actionSheet.setLoadingState(true);
    },
    removeLoadingState() {
        this.actionSheet.setLoadingState(false);
    }
};

export default AddsModelLoadingStateToActionSheet;
