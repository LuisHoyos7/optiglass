
const findAll = () => {
    return new Promise((resolve, reject) => {
        $.ajax({
          data: null,
          url: 'roles',
          success: function (data) {
            resolve(data)
          },
          error: function (error) {
            reject(error)
          },
        })
    })
}

export default { findAll };
