import moment from 'moment'

export const dateToYear = date => moment(date).format('YYYY')
export const dateToMonth = date => moment(date).format('MMM YYYY')
export const dateToWeek = date => moment(date).format('GGGG-[W]WW')
export const dateToDay = date => moment(date).format('YYYY-MM-DD')
export const dateToDayFormat = date => moment(date).format('DD')
export const dateBeautify = date => moment(date).format('Do MMMM YYYY')
export const firstDateOfCurrentMonth = date => moment().startOf('month').format('YYYY-MM-DD');
export const endDateOfCurrentMonth = date => moment().endOf('month').format('YYYY-MM-DD');
export const firstDateOfCurrentYear = date => moment().startOf('year').format('YYYY-MM-DD');
export const firstDateOfCurrentWeek = date => moment().startOf('isoWeek').format('YYYY-MM-DD');
export const firstDateOflastWeek = date => moment().subtract(1, 'weeks').startOf('isoWeek').format('YYYY-MM-DD');
export const endDateOflastWeek = date => moment().subtract(1, 'weeks').endOf('isoWeek').format('YYYY-MM-DD');

export const firstDateOflastMonth = date => moment().subtract(1, 'month').startOf('month').format('YYYY-MM-DD');
export const endDateOflastMonth = date => moment().subtract(1, 'month').endOf('month').format('YYYY-MM-DD');