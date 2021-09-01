const filter = () => {
    return new Promise((resolve, reject) => {
        $.ajax({
          data: null,
          url: 'errores/filtro',
          success: function (data) {
            resolve(data)
          },
          error: function (error) {
            reject(error)
          },
        })
    })
  }
  
  export default { filter };