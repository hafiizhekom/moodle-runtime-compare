import http from 'k6/http';
import { check, sleep } from 'k6';
import { htmlReport } from "https://raw.githubusercontent.com/benc-uk/k6-reporter/main/dist/bundle.js";
import { textSummary } from "https://jslib.k6.io/k6-summary/0.0.1/index.js";

export const options = {
  vus: 10,
  duration: '30s',
};

export default function () {
  const res = http.get('http://moodle:80');
}

export function handleSummary(data) {
  const customizedData = {
    http_reqs: data.metrics.http_reqs.values.count,
    rate: data.metrics.http_reqs.values.rate,
    avg_response_time: data.metrics['http_req_duration{expected_response:true}'].values.avg
  }

  return {
    "/reports/10/summary.html": htmlReport(data),
    "/reports/10/summary.txt": textSummary(data, { indent: " ", enableColors: true }),
    "/reports/10/summary.json": JSON.stringify(data),
    "/reports/10/summary_short.json": JSON.stringify(customizedData),
  };
}