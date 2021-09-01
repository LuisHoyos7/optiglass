
const create = (data) => {
    return new Promise((resolve, reject) => {
        $.ajax({
          data: data,
          url: 'callsdealer',
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

export default { create }