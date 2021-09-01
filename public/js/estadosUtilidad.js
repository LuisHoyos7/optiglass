
const estados = () => {
    return new Promise((resolve, reject) => {
        $.ajax({
          data: null,
          url: 'estados/activo',
          success: function (data) {
            resolve(data)
          },
          error: function (error) {
            reject(error)
          },
        })
    })
}

export default { estados };