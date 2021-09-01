const filtroCanton = (cantones, valor) =>  cantones.filter(item => item.provincia === valor); 
const filtroParroquia = (parroquias, valor) =>  parroquias.filter(item => item.canton === valor); 

export default { filtroCanton, filtroParroquia};