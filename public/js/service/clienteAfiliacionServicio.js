const findById = (id) => {
    return new Promise((resolve, reject) => {
        $.ajax({
            data: null,
            url: "clientesafiliacion/" + id,
            success: function (data) {
                resolve(data);
            },
            error: function (error) {
                reject(error);
            },
        });
    });
};

const findByPhonenumber = (filter) => {
    return new Promise((resolve, reject) => {
        $.ajax({
            data: null,
            url: `clientesafiliacion/telefono?${filter}`,
            success: function (data) {
                resolve(data);
            },
            error: function (error) {
                reject(error);
            },
        });
    });
};

const update = (data, id) => {
    return new Promise((resolve, reject) => {
        $.ajax({
            data: data,
            url: "clientesafiliacion/" + id,
            type: "put",
            dataType: "JSON",
            success: function (data) {
                resolve(data);
            },
            error: function (error) {
                reject(error);
            },
        });
    });
};

export default { findById, findByPhonenumber, update };
