

export const numberWithSpaces = (x) => x ? x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") : x;
