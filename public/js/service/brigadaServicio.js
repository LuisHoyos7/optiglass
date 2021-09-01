const create = (data) => {
  return new Promise((resolve, reject) => {
      $.ajax({
        data: data,
        url: 'brigadas',
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
        url: 'brigadas/'+id,
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

const findById = (id) => {
  return new Promise((resolve, reject) => {
      $.ajax({
        data: null,
        url: 'brigadas/'+id,
        success: function (data) {
          resolve(data)
        },
        error: function (error) {
          reject(error)
        },
      })
  })
} 

const filter = (filter) => {
    return new Promise((resolve, reject) => {
        $.ajax({
          data: null,
          url: 'brigadas/filtro?estado='+filter,
          success: function (data) {
            resolve(data)
          },
          error: function (error) {
            reject(error)
          },
        })
    })
}

const getBridasAfiliacion = (filter) => {
  return new Promise((resolve, reject) => {
      $.ajax({
        data: null,
        url: `brigadas/afiliacion?${filter}`,
        success: function (data) {
          resolve(data)
        },
        error: function (error) {
          reject(error)
        },
      })
  })
}

export default { create, update, findById, filter , getBridasAfiliacion };
