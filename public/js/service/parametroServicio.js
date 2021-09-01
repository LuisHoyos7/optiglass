const findById = (id) => {
    return new Promise((resolve, reject) => {
        $.ajax({
            data: null,
            url: "parametossistema/" + id,
            success: function (data) {
                resolve(data);
            },
            error: function (error) {
                reject(error);
            },
        });
    });
};

export default { findById };
