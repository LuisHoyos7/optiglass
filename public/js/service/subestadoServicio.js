const filter = (filter) => {
    return new Promise((resolve, reject) => {
        $.ajax({
          data: null,
          url: 'subestados/filtro?estado='+filter,
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