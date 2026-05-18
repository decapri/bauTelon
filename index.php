<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kalkulator Financial Model - Proyek Minyak</title>
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500&family=IBM+Plex+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --bg: #f5f2eb;
    --surface: #ffffff;
    --surface2: #f0ece0;
    --ink: #1a1814;
    --ink2: #4a4540;
    --ink3: #8a8278;
    --accent: #b84a2e;
    --accent2: #2e5b8a;
    --accent3: #2a7a4a;
    --border: rgba(26,24,20,0.12);
    --border2: rgba(26,24,20,0.06);
    --mono: 'IBM Plex Mono', monospace;
    --sans: 'IBM Plex Sans', sans-serif;
  }

  @media (prefers-color-scheme: dark) {
    :root {
      --bg: #1a1814;
      --surface: #24221e;
      --surface2: #2e2c27;
      --ink: #f0ece0;
      --ink2: #c8c4b8;
      --ink3: #7a7870;
      --border: rgba(240,236,224,0.10);
      --border2: rgba(240,236,224,0.05);
    }
  }

  body {
    font-family: var(--sans);
    background: var(--bg);
    color: var(--ink);
    font-size: 15px;
    line-height: 1.6;
    min-height: 100vh;
  }

  header {
    background: var(--ink);
    color: #f0ece0;
    padding: 2rem 2.5rem 1.8rem;
    display: flex;
    align-items: flex-end;
    gap: 1.5rem;
    border-bottom: 3px solid var(--accent);
  }

  .header-icon {
    font-size: 2.8rem;
    line-height: 1;
    opacity: 0.9;
  }

  header h1 {
    font-family: var(--mono);
    font-size: 1.4rem;
    font-weight: 500;
    letter-spacing: -0.02em;
    line-height: 1.2;
  }

  header p {
    font-size: 0.82rem;
    color: rgba(240,236,224,0.55);
    margin-top: 4px;
    font-weight: 300;
    letter-spacing: 0.04em;
    text-transform: uppercase;
  }

  .main-wrap {
    max-width: 1100px;
    margin: 0 auto;
    padding: 2rem 2rem 3rem;
  }

  .section-label {
    font-family: var(--mono);
    font-size: 0.7rem;
    font-weight: 500;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--ink3);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .section-label::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--border);
  }

  .card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
  }

  .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
  .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
  .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; }

  .input-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
  }

  label {
    font-size: 0.78rem;
    font-weight: 500;
    color: var(--ink2);
    letter-spacing: 0.02em;
  }

  input[type="number"], select {
    font-family: var(--mono);
    font-size: 0.9rem;
    padding: 8px 10px;
    border: 1px solid var(--border);
    border-radius: 5px;
    background: var(--surface2);
    color: var(--ink);
    width: 100%;
    transition: border-color 0.15s;
  }

  input[type="number"]:focus, select:focus {
    outline: none;
    border-color: var(--accent2);
  }

  .input-unit {
    font-size: 0.72rem;
    color: var(--ink3);
    font-family: var(--mono);
  }

  .btn-calc {
    font-family: var(--mono);
    font-size: 0.85rem;
    font-weight: 500;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    background: var(--accent);
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 12px 2rem;
    cursor: pointer;
    transition: opacity 0.15s, transform 0.1s;
    width: 100%;
    margin-top: 0.5rem;
  }

  .btn-calc:hover { opacity: 0.88; }
  .btn-calc:active { transform: scale(0.98); }

  .kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
  }

  .kpi {
    background: var(--surface2);
    border-radius: 6px;
    padding: 1rem 1.1rem;
  }

  .kpi-label {
    font-size: 0.72rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--ink3);
    margin-bottom: 6px;
  }

  .kpi-value {
    font-family: var(--mono);
    font-size: 1.3rem;
    font-weight: 500;
    color: var(--ink);
  }

  .kpi-value.green { color: var(--accent3); }
  .kpi-value.red { color: var(--accent); }
  .kpi-value.blue { color: var(--accent2); }

  .kpi-sub {
    font-size: 0.7rem;
    color: var(--ink3);
    margin-top: 2px;
  }

  .table-wrap {
    overflow-x: auto;
    border: 1px solid var(--border);
    border-radius: 7px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.78rem;
  }

  thead tr {
    background: var(--ink);
    color: #f0ece0;
  }

  thead th {
    font-family: var(--mono);
    font-weight: 500;
    padding: 9px 10px;
    text-align: right;
    white-space: nowrap;
    font-size: 0.72rem;
    letter-spacing: 0.03em;
  }

  thead th:first-child { text-align: center; }

  tbody tr:nth-child(odd) { background: var(--surface2); }
  tbody tr:nth-child(even) { background: var(--surface); }

  tbody tr:last-child {
    background: var(--ink);
    color: #f0ece0;
    font-weight: 500;
  }

  td {
    font-family: var(--mono);
    padding: 7px 10px;
    text-align: right;
    color: var(--ink);
    white-space: nowrap;
  }

  td:first-child {
    text-align: center;
    font-weight: 500;
    color: var(--ink2);
  }

  tbody tr:last-child td { color: #f0ece0; }

  td.pos { color: var(--accent3); }
  td.neg { color: var(--accent); }

  .chart-wrap {
    position: relative;
    height: 280px;
    width: 100%;
  }

  .badge {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 3px;
    font-size: 0.68rem;
    font-weight: 500;
    font-family: var(--mono);
    letter-spacing: 0.04em;
    background: rgba(46, 91, 138, 0.12);
    color: var(--accent2);
    margin-left: 6px;
  }

  .note {
    font-size: 0.75rem;
    color: var(--ink3);
    padding: 0.7rem 1rem;
    background: var(--surface2);
    border-radius: 5px;
    border-left: 2px solid var(--accent2);
    margin-top: 1rem;
  }

  .prod-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 8px;
  }

  @media (max-width: 700px) {
    .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; }
    .prod-grid { grid-template-columns: repeat(4, 1fr); }
    header { padding: 1.5rem; flex-direction: column; align-items: flex-start; gap: 0.5rem; }
    .main-wrap { padding: 1rem; }
  }
</style>
</head>
<body>

<header>
  <div class="header-icon">⛽</div>
  <div>
    <h1>Financial Model — Proyek Minyak</h1>
    <p>Perhitungan NCF · Depresiasi · Pajak &amp; NPV</p>
  </div>
</header>

<div class="main-wrap">

  <!-- INPUT SECTION -->
  <div class="section-label">01 · Parameter Input</div>

  <div class="card">
    <div class="grid-2" style="gap: 2rem;">
      <div>
        <div class="section-label" style="font-size:0.65rem; margin-bottom:0.8rem;">Proyek &amp; Investasi</div>
        <div style="display:flex; flex-direction:column; gap:12px;">
          <div class="input-group">
            <label>Jangka Waktu Proyek</label>
            <input type="number" id="nYears" value="20" min="1" max="40">
            <span class="input-unit">tahun</span>
          </div>
          <div class="grid-2">
            <div class="input-group">
              <label>Investasi Capital</label>
              <input type="number" id="capInv" value="13000">
              <span class="input-unit">$M</span>
            </div>
            <div class="input-group">
              <label>Investasi Non-Capital</label>
              <input type="number" id="nonCapInv" value="8000">
              <span class="input-unit">$M</span>
            </div>
          </div>
          <div class="input-group">
            <label>Opex Tahun ke-1</label>
            <input type="number" id="opex1" value="180" step="0.01">
            <span class="input-unit">$M/tahun</span>
          </div>
          <div class="input-group">
            <label>Laju Kenaikan Opex</label>
            <input type="number" id="opexGrowth" value="2.5" step="0.1" min="0" max="20">
            <span class="input-unit">% per tahun</span>
          </div>
        </div>
      </div>
      <div>
        <div class="section-label" style="font-size:0.65rem; margin-bottom:0.8rem;">Produksi, Harga &amp; Pajak</div>
        <div style="display:flex; flex-direction:column; gap:12px;">
          <div class="input-group">
            <label>Harga Minyak</label>
            <input type="number" id="price" value="32" step="0.1">
            <span class="input-unit">$/bbl</span>
          </div>
          <div class="grid-2">
            <div class="input-group">
              <label>Decline Rate</label>
              <input type="number" id="decline" value="3" step="0.1" min="0" max="50">
              <span class="input-unit">% per tahun (thn 4+)</span>
            </div>
            <div class="input-group">
              <label>Tax Rate</label>
              <input type="number" id="taxRate" value="51" step="0.1" min="0" max="100">
              <span class="input-unit">%</span>
            </div>
          </div>
          <div class="input-group">
            <label>Metode Depresiasi</label>
            <select id="deprMethod">
              <option value="sl">Straight Line (SL) — Di = K/N</option>
              <option value="dd">Declining Balance (DD) — Di = K·R</option>
            </select>
          </div>
          <div class="input-group">
            <label>Discount Rate (i)</label>
            <input type="number" id="discRate" value="10" step="0.5" min="1" max="30">
            <span class="input-unit">% per tahun</span>
          </div>
        </div>
      </div>
    </div>

    <div style="margin-top:1.5rem;">
      <div class="section-label" style="font-size:0.65rem; margin-bottom:0.8rem;">Produksi Tahun 1–7 (Mbbl)</div>
      <div class="prod-grid">
        <div class="input-group"><label>Thn 1</label><input type="number" id="p1" value="175" min="0"></div>
        <div class="input-group"><label>Thn 2</label><input type="number" id="p2" value="201" min="0"></div>
        <div class="input-group"><label>Thn 3</label><input type="number" id="p3" value="217" min="0"></div>
        <div class="input-group"><label>Thn 4</label><input type="number" id="p4" value="198" min="0"></div>
        <div class="input-group"><label>Thn 5</label><input type="number" id="p5" value="192.06" min="0"></div>
        <div class="input-group"><label>Thn 6</label><input type="number" id="p6" value="186.29" min="0"></div>
        <div class="input-group"><label>Thn 7</label><input type="number" id="p7" value="180.7" min="0"></div>
      </div>
    </div>

    <button class="btn-calc" onclick="calculate()">⟳ Hitung Financial Model</button>
  </div>

  <!-- KPI OUTPUT -->
  <div class="section-label">02 · Indikator Kinerja</div>
  <div class="kpi-grid" id="kpiGrid">
    <div class="kpi"><div class="kpi-label">Total NCF Undiscounted</div><div class="kpi-value" id="kpi-ncf">—</div><div class="kpi-sub">$M</div></div>
    <div class="kpi"><div class="kpi-label">NPV @ i%</div><div class="kpi-value green" id="kpi-npv">—</div><div class="kpi-sub">$M</div></div>
    <div class="kpi"><div class="kpi-label">Total Investasi</div><div class="kpi-value red" id="kpi-inv">—</div><div class="kpi-sub">$M</div></div>
    <div class="kpi"><div class="kpi-label">Total Produksi</div><div class="kpi-value blue" id="kpi-prod">—</div><div class="kpi-sub">Mbbl</div></div>
    <div class="kpi"><div class="kpi-label">Total Pajak</div><div class="kpi-value" id="kpi-tax">—</div><div class="kpi-sub">$M</div></div>
    <div class="kpi"><div class="kpi-label">Depresiasi/thn</div><div class="kpi-value" id="kpi-depr">—</div><div class="kpi-sub">$M (metode SL)</div></div>
  </div>

  <!-- CHARTS -->
  <div class="section-label">03 · Grafik</div>
  <div class="grid-2" style="margin-bottom:1.5rem;">
    <div class="card">
      <div style="font-size:0.78rem; font-weight:500; color:var(--ink2); margin-bottom:1rem;">Net Cash Flow per Tahun ($M)</div>
      <div class="chart-wrap"><canvas id="chartNCF" role="img" aria-label="NCF per tahun">NCF tahunan proyek minyak</canvas></div>
    </div>
    <div class="card">
      <div style="font-size:0.78rem; font-weight:500; color:var(--ink2); margin-bottom:1rem;">Produksi per Tahun (Mbbl)</div>
      <div class="chart-wrap"><canvas id="chartProd" role="img" aria-label="Produksi per tahun">Produksi tahunan proyek minyak</canvas></div>
    </div>
  </div>

  <div class="card" style="margin-bottom:1.5rem;">
    <div style="font-size:0.78rem; font-weight:500; color:var(--ink2); margin-bottom:1rem;">Kumulatif NCF vs Investasi ($M)</div>
    <div class="chart-wrap" style="height:220px;"><canvas id="chartCum" role="img" aria-label="Kumulatif NCF vs investasi">Kumulatif NCF proyek</canvas></div>
  </div>

  <!-- TABLE -->
  <div class="section-label">04 · Tabel Perhitungan Lengkap</div>
  <div class="table-wrap" id="tableWrap">
    <table>
      <thead>
        <tr>
          <th>Thn</th>
          <th>Produksi (Mbbl)</th>
          <th>Income ($M)</th>
          <th>Inv. Capital ($M)</th>
          <th>Inv. Non-Cap ($M)</th>
          <th>Opex ($M)</th>
          <th>Depresiasi ($M)</th>
          <th>Taxable Income ($M)</th>
          <th>Tax ($M)</th>
          <th>NCF Undiscounted ($M)</th>
          <th>Discount Factor</th>
          <th>NCF Discounted ($M)</th>
        </tr>
      </thead>
      <tbody id="tableBody"></tbody>
    </table>
  </div>

  <div class="note">
    ℹ️ <strong>Rumus NCF:</strong> NCF = Income − Opex − Tax &nbsp;|&nbsp;
    <strong>Taxable Income:</strong> TI = Income − Opex − Di &nbsp;|&nbsp;
    <strong>Tax:</strong> Tax = TI × tarif &nbsp;|&nbsp;
    <strong>Depresiasi SL:</strong> Di = K / N &nbsp;|&nbsp;
    <strong>Depresiasi DD:</strong> Di = K × (1/N) × (1 − 1/N)^(t−1) &nbsp;|&nbsp;
    <strong>NPV:</strong> Σ NCF<sub>t</sub> / (1+i)^t
  </div>

</div>

<script>
let chartNCF, chartProd, chartCum;

function fmt(v, d=2) {
  if (v === undefined || v === null || isNaN(v)) return '—';
  return v.toLocaleString('id-ID', {minimumFractionDigits: d, maximumFractionDigits: d});
}

function calculate() {
  const n    = parseInt(document.getElementById('nYears').value);
  const capK = parseFloat(document.getElementById('capInv').value);
  const ncK  = parseFloat(document.getElementById('nonCapInv').value);
  const K    = capK; // depreciable capital
  const opex1= parseFloat(document.getElementById('opex1').value);
  const opexG= parseFloat(document.getElementById('opexGrowth').value) / 100;
  const price= parseFloat(document.getElementById('price').value);
  const decR = parseFloat(document.getElementById('decline').value) / 100;
  const taxR = parseFloat(document.getElementById('taxRate').value) / 100;
  const disc = parseFloat(document.getElementById('discRate').value) / 100;
  const meth = document.getElementById('deprMethod').value;

  const baseProd = [
    parseFloat(document.getElementById('p1').value),
    parseFloat(document.getElementById('p2').value),
    parseFloat(document.getElementById('p3').value),
    parseFloat(document.getElementById('p4').value),
    parseFloat(document.getElementById('p5').value),
    parseFloat(document.getElementById('p6').value),
    parseFloat(document.getElementById('p7').value),
  ];

  const R = 1 / n;

  // Build rows
  const rows = [];

  // Year 0
  rows.push({
    t: 0, prod: 0, income: 0,
    invCap: capK, invNonCap: ncK,
    opex: 0, di: 0, ti: 0, tax: 0,
    ncf: -(capK + ncK),
    df: 1,
    ncfDisc: -(capK + ncK)
  });

  let totalNCF = 0, totalNCFDisc = 0, totalProd = 0, totalTax = 0;
  let cumNCF = [-(capK + ncK)];

  for (let t = 1; t <= n; t++) {
    let prod;
    if (t <= 7) {
      prod = baseProd[t - 1];
    } else {
      prod = rows[t - 1].prod * (1 - decR);
    }

    const income = prod * price;
    const opex = opex1 * Math.pow(1 + opexG, t - 1);

    let di;
    if (meth === 'sl') {
      di = K / n;
    } else {
      di = K * R * Math.pow(1 - R, t - 1);
    }

    const ti = income - opex - di;
    const tax = ti > 0 ? ti * taxR : 0;
    const ncf = income - opex - tax;
    const df = 1 / Math.pow(1 + disc, t);
    const ncfDisc = ncf * df;

    totalNCF += ncf;
    totalNCFDisc += ncfDisc;
    totalProd += prod;
    totalTax += tax;

    const cumPrev = cumNCF[cumNCF.length - 1];
    cumNCF.push(cumPrev + ncf);

    rows.push({ t, prod, income, invCap: 0, invNonCap: 0, opex, di, ti, tax, ncf, df, ncfDisc });
  }

  const netNPV = totalNCFDisc - (capK + ncK);

  // KPIs
  document.getElementById('kpi-ncf').textContent = fmt(totalNCF - (capK + ncK));
  document.getElementById('kpi-npv').textContent = fmt(netNPV);
  document.getElementById('kpi-inv').textContent = fmt(capK + ncK);
  document.getElementById('kpi-prod').textContent = fmt(totalProd, 1);
  document.getElementById('kpi-tax').textContent = fmt(totalTax);
  document.getElementById('kpi-depr').textContent = meth === 'sl' ? fmt(K / n) : 'Menurun';

  // Table
  const tbody = document.getElementById('tableBody');
  tbody.innerHTML = '';
  let totRow = {prod:0, income:0, invCap:0, invNonCap:0, opex:0, di:0, ti:0, tax:0, ncf:0, ncfDisc:0};

  rows.forEach(r => {
    const tr = document.createElement('tr');
    const ncfClass = r.ncf < 0 ? 'neg' : (r.t === 0 ? 'neg' : 'pos');
    tr.innerHTML = `
      <td>${r.t}</td>
      <td>${r.prod ? fmt(r.prod, 2) : '—'}</td>
      <td>${r.income ? fmt(r.income) : '—'}</td>
      <td>${r.invCap ? fmt(r.invCap) : '—'}</td>
      <td>${r.invNonCap ? fmt(r.invNonCap) : '—'}</td>
      <td>${r.opex ? fmt(r.opex) : '—'}</td>
      <td>${r.di ? fmt(r.di) : '—'}</td>
      <td>${r.ti ? fmt(r.ti) : '—'}</td>
      <td>${r.tax ? fmt(r.tax) : '—'}</td>
      <td class="${ncfClass}">${fmt(r.ncf)}</td>
      <td>${fmt(r.df, 4)}</td>
      <td class="${r.ncfDisc < 0 ? 'neg' : 'pos'}">${fmt(r.ncfDisc)}</td>
    `;
    tbody.appendChild(tr);

    if (r.t > 0) {
      totRow.prod += r.prod;
      totRow.income += r.income;
      totRow.opex += r.opex;
      totRow.di += r.di;
      totRow.ti += r.ti;
      totRow.tax += r.tax;
      totRow.ncf += r.ncf;
      totRow.ncfDisc += r.ncfDisc;
    }
  });

  const tr = document.createElement('tr');
  tr.innerHTML = `
    <td>Total</td>
    <td>${fmt(totRow.prod, 1)}</td>
    <td>${fmt(totRow.income)}</td>
    <td>${fmt(capK)}</td>
    <td>${fmt(ncK)}</td>
    <td>${fmt(totRow.opex)}</td>
    <td>${fmt(totRow.di)}</td>
    <td>${fmt(totRow.ti)}</td>
    <td>${fmt(totRow.tax)}</td>
    <td>${fmt(totRow.ncf - (capK + ncK))}</td>
    <td>—</td>
    <td>${fmt(totRow.ncfDisc - (capK + ncK))}</td>
  `;
  tbody.appendChild(tr);

  // Charts
  const labels = rows.map(r => `Thn ${r.t}`);
  const ncfData = rows.map(r => parseFloat(r.ncf.toFixed(2)));
  const prodData = rows.map(r => parseFloat(r.prod.toFixed(2)));

  updateChart('chartNCF', chartNCF, {
    labels,
    datasets: [{
      label: 'NCF ($M)',
      data: ncfData,
      backgroundColor: ncfData.map(v => v >= 0 ? 'rgba(42,122,74,0.75)' : 'rgba(184,74,46,0.75)'),
      borderColor: ncfData.map(v => v >= 0 ? '#2a7a4a' : '#b84a2e'),
      borderWidth: 1
    }]
  }, 'bar');
  chartNCF = Chart.getChart('chartNCF');

  updateChart('chartProd', chartProd, {
    labels: labels.slice(1),
    datasets: [{
      label: 'Produksi (Mbbl)',
      data: prodData.slice(1),
      fill: true,
      backgroundColor: 'rgba(46,91,138,0.15)',
      borderColor: '#2e5b8a',
      borderWidth: 2,
      tension: 0.35,
      pointRadius: 3,
      pointBackgroundColor: '#2e5b8a'
    }]
  }, 'line');
  chartProd = Chart.getChart('chartProd');

  const cumDiscounted = [];
  let running = 0;
  rows.forEach(r => { running += r.ncfDisc; cumDiscounted.push(parseFloat(running.toFixed(2))); });

  updateChart('chartCum', chartCum, {
    labels,
    datasets: [
      {
        label: 'Kumulatif NCF Undiscounted',
        data: cumNCF.map(v => parseFloat(v.toFixed(2))),
        fill: false,
        borderColor: '#2a7a4a',
        borderWidth: 2,
        tension: 0.3,
        pointRadius: 2
      },
      {
        label: 'Kumulatif NCF Discounted',
        data: cumDiscounted,
        fill: false,
        borderColor: '#2e5b8a',
        borderWidth: 2,
        borderDash: [5,4],
        tension: 0.3,
        pointRadius: 2
      },
      {
        label: 'Total Investasi',
        data: labels.map(() => -(capK + ncK)),
        fill: false,
        borderColor: '#b84a2e',
        borderWidth: 1.5,
        borderDash: [8,4],
        pointRadius: 0
      }
    ]
  }, 'line');
  chartCum = Chart.getChart('chartCum');
}

function updateChart(id, existing, data, type) {
  if (existing) existing.destroy();
  const ctx = document.getElementById(id).getContext('2d');
  new Chart(ctx, {
    type,
    data,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: type !== 'bar',
          labels: { font: { family: "'IBM Plex Mono', monospace", size: 11 }, boxWidth: 14, padding: 14 }
        }
      },
      scales: {
        x: {
          ticks: { font: { family: "'IBM Plex Mono', monospace", size: 10 }, autoSkip: true, maxRotation: 45 },
          grid: { color: 'rgba(128,128,128,0.1)' }
        },
        y: {
          ticks: { font: { family: "'IBM Plex Mono', monospace", size: 10 }, callback: v => v.toLocaleString('id-ID') },
          grid: { color: 'rgba(128,128,128,0.1)' }
        }
      }
    }
  });
}

// Auto-calculate on load
window.addEventListener('load', calculate);
</script>
</body>
</html>