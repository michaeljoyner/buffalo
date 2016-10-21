module.exports = class Upload {

    constructor(name, status) {
        this.name = name;
        this.status = status;
        this.progress = 0;
    }

    setProgress(progress) {
        this.progress = progress;
    }

    setStatus(status) {
        this.status =status;
    }
}