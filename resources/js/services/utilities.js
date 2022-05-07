const utils = {

    /**
     * Generate Form Data
     *
     * @param {Array} [items] array of key/value object
     * @return {FormData} FormData
     */
    createForm: (items) => {
        let form = new FormData();

        items.forEach((item) => {
            form.set(item["key"], item["value"]);
        });

        return form;
    },
    /**
     * Return The specefic Area from tooth
     * @example "Secteur 01" , "Secteur 02" , "Secteur 03" , "Secteur 04" , "Bouche" , or Num dent
     */
    getAreaFromTooth: (teeth) => {
        switch (teeth) {
            case "11,12,13,14,15,16,17,18,21,22,23,24,25,26,27,28,41,42,43,44,45,46,47,48,31,32,33,34,35,36,37,38":
                return "Bouche";
                break;
            case "s1":
                return "Secteur 01";
                break;
            case "s2":
                return "Secteur 02";
                break;
            case "s3":
                return "Secteur 03";
                break;
            case "s4":
                return "Secteur 04";
                break;
            default:
                return teeth;
                break;
        }
    },
    /**
     * Get tooth from SECTORS
     * @param {String} sector Selected sector from schema
     * @returns {Array} tooth list of tooth from the selected sector
     */
    getToothFrom: (sector) => {
        switch (sector) {
            case "s1":
                return [11, 12, 13, 14, 15, 16, 17, 18];

            case "s2":
                return [21, 22, 23, 24, 25, 26, 27, 28];

            case "s3":
                return [41, 42, 43, 44, 45, 46, 47, 48];

            case "s4":
                return [31, 32, 33, 34, 35, 36, 37, 38];

        }
        return;
    }
}

export default utils;