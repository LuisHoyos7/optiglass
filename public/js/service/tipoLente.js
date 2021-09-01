const findAll = () => {
    return new Promise((resolve, reject) => {
        $.ajax({
          data: null,
          url: 'lentes',
          success: function (data) {
            resolve(data)
          },
          error: function (error) {
            reject(error)
          },
        })
    })
}

const create = (data) => {
    return new Promise((resolve, reject) => {
        $.ajax({
          data: data,
          url: 'lentes',
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
          url: 'lentes/'+id,
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

export default { findAll, create, update }