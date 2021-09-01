
const create = (data) => {
    return new Promise((resolve, reject) => {
        $.ajax({
          data: data,
          url: 'afiliaciones',
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
        url: 'afiliaciones/'+id,
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

const updateLote = (data) => {
  return new Promise((resolve, reject) => {
      $.ajax({
        data: data,
        url: 'afiliaciones/lote',
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

export default { create, update, updateLote };