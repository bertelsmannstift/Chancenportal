class DetectScrollbar {
    constructor() {
        this.scrollbarWidth = 0;
        this.hasScrollBar();
        this.getScrollBarWidth();
    }
    hasScrollBar() {
        return (document.documentElement.scrollHeight !== document.documentElement.clientHeight);
    };
    getScrollBarWidth(recalculate) {
        if(!window.scrollBarWidth || recalculate === true) {
            const scrollDiv = document.createElement("div");
            scrollDiv.className = "detectScrollbar__scrollbar-width-helper";
            scrollDiv.setAttribute('style', 'width:100px;height:100px;overflow:scroll;position:absolute;top:-99999px;');
            document.body.appendChild(scrollDiv);
            this.scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;
            window.scrollBarWidth = this.scrollbarWidth;
            document.body.removeChild(scrollDiv);
        }
        return this.scrollbarWidth;
    };
}
export default new DetectScrollbar();
