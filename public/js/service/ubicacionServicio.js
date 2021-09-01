const provincias = () => {
    return new Promise((resolve, reject) => {
        $.ajax({
          data: null,
          url: 'ubicaciones/provincias',
          success: function (data) {
            resolve(data)
          },
          error: function (error) {
            reject(error)
          },
        })
    })
}

const cantones = () => {
  return new Promise((resolve, reject) => {
    $.ajax({
      data: null,
      url: 'ubicaciones/cantones',
      success: function (data) {
        resolve(data)
      },
      error: function (error) {
        reject(error)
      },
    })
  })
}

const parroquias = () => {
  return new Promise((resolve, reject) => {
    $.ajax({
      data: null,
      url: 'ubicaciones/parroquias',
      success: function (data) {
        resolve(data)
      },
      error: function (error) {
        reject(error)
      },
    })
  })
}

export default { provincias, cantones, parroquias };