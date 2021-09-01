
const findAll = () => {
    return new Promise((resolve, reject) => {
        $.ajax({
          data: null,
          url: 'usuarios',
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
          url: 'usuarios',
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

const update = (data, codigo) => {
    return new Promise((resolve, reject) => {
        $.ajax({
          data: data,
          url: 'usuarios/'+codigo,
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

const changePassword = (data, codigo) => {
    return new Promise((resolve, reject) => {
        $.ajax({
          data: data,
          url: 'usuarios/'+codigo+'/clave',
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

const filter = (filter) => {
  return new Promise((resolve, reject) => {
      $.ajax({
        data: null,
        url: 'usuarios/filtro?rol='+filter,
        success: function (data) {
          resolve(data)
        },
        error: function (error) {
          reject(error)
        },
      })
  })
}

const getUserLogin = () => {
  return new Promise((resolve, reject) => {
      $.ajax({
        data: null,
        url: 'usuarios/login',
        success: function (data) {
          resolve(data)
        },
        error: function (error) {
          reject(error)
        },
      })
  })
}

export default { findAll, create, update, changePassword, filter, getUserLogin };