class BirdboardForm {
    constructor($data) {
        this.originData = JSON.parse(JSON.stringify(data));
        Object.assign(this, data);

        this.errors = {};

    }
    data() {

        return Object.keys(this.originalData).reduce((data, attribute) => {
            data[attribute] = this[attribute];

            return data;
        }, {

        });
    }

    post(endpoint) {
        this.submit(endpoint);
    }
    patch(endpoint) {
        this.submit(endpoint, 'patch');
    }
    delete(endpoint) {
        this.submit(endpoint, 'delete');
    }
    submit(endpoint, requestType = 'post') {
        return axios[requestType](endpoint, this.data())
            .catch(this.onFail.bind(this))
            .then(this.onSuccess.bind(this));
    }


    onSuccess() {
        this.submitted = true;
        this.errors = {};
        return response;
    }

    onFail(error) {
        this.errors = erro.response.data.errors;
        this.submitted = false;

        throw error;
    }

    reset() {

        Object.assign(this, this.originalData);

        throw error;
    }
}
export default BirdboardForm;
