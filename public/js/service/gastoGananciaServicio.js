const create = (data) => {
    return new Promise((resolve, reject) => {
        $.ajax({
          data: data,
          url: 'gastosganancias',
          type: 'post',
          dataType: 'JSON',
          success: function (data) {
            resolve(data)
          },
          error: function (error) {
            reject(error)
          },
        })
    })
}

const update = (data, id) => {
    return new Promise((resolve, reject) => {
        $.ajax({
          data: data,
          url: 'gastosganancias/'+id,
          type: 'put',
          dataType: 'JSON',
          success: function (data) {
            resolve(data)
          },
          error: function (error) {
            reject(error)
          },
        })
    })
}

const getConfiguracion = (filter) => {
    return new Promise((resolve, reject) => {
        $.ajax({
          data: null,
          url: 'gastosganancias/configuracion?'+filter,
          success: function (data) {
            resolve(data)
          },
          error: function (error) {
            reject(error)
          },
        })
    })
  }

export default { create, update, getConfiguracion };