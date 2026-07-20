@extends('layouts.app')
@section('title', 'Dashboard Ketua Posyandu — Posyandu Melati 2')

@push('styles')
<style>
  .welcome-banner {
  background: linear-gradient(135deg,#0a3d39,#0f766e 50%,#14b8a6);
  border-radius: 16px;
  padding: 20px 24px;
  color: #fff;
  margin-bottom: 16px;
  display: flex;
  align-items: center;
  gap: 16px;
}
.dp-box {
  display: flex;
  align-items: center;
  gap: 8px;
  background: rgba(255,255,255,.13);
  border: 1.5px solid rgba(255,255,255,.28);
  border-radius: 12px;
  padding: 8px 14px;
  backdrop-filter: blur(8px);
}
/* stat-card, stat-icon, stat-value, stat-label, stat-delta, delta-up styles are now defined globally in layouts/app.blade.php */
.card { background:#fff;border-radius:14px;box-shadow:0 1px 4px rgba(0,0,0,.06);overflow:hidden; }
.card-header { display:flex;align-items:center;justify-content:space-between;padding:14px 18px 12px;border-bottom:1px solid var(--slate-100,#f1f5f9); }
.card-title { font-size:14px;font-weight:700;color:var(--slate-800,#1e293b); }
.card-subtitle { font-size:11px;color:var(--slate-400,#94a3b8);margin-top:2px; }
.data-table { width:100%;border-collapse:collapse;font-size:13px; }
.data-table thead th { font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:var(--slate-400,#94a3b8);padding:10px 14px;background:var(--slate-50,#f8fafc);border-bottom:1px solid var(--slate-100,#f1f5f9);text-align:center; }
.data-table thead th:first-child { text-align:left; }
.data-table tbody td { padding:12px 14px;border-bottom:1px solid var(--slate-50,#f8fafc);vertical-align:middle;text-align:center;color:var(--slate-700,#334155); }
.data-table tbody td:first-child { text-align:left; }
.data-table tbody tr:last-child td { border-bottom:none; }
.data-table tbody tr:hover td { background:#fafbff; }
.cell-with-avatar { display:flex;align-items:center;gap:10px; }
.avatar-table { width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#fff;flex-shrink:0; }
.cell-name { font-weight:600;font-size:13px;color:var(--slate-800,#1e293b); }
.cell-meta { font-size:11px;color:var(--slate-400,#94a3b8);margin-top:2px; }
.badge { display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600; }
.badge-purple{background:#f3e8ff;color:#7c3aed;} .badge-blue{background:#dbeafe;color:#2563eb;}
.badge-green{background:#dcfce7;color:#16a34a;} .badge-red{background:#fee2e2;color:#dc2626;} .badge-orange{background:#ffedd5;color:#ea580c;}
.btn { display:inline-flex;align-items:center;gap:6px;border-radius:8px;font-size:13px;font-weight:600;padding:7px 14px;cursor:pointer;text-decoration:none;transition:all .15s;border:none; }
.btn-outline { border:1.5px solid var(--slate-200,#e2e8f0);color:var(--slate-600,#475569);background:#fff; }
.btn-outline:hover { border-color:var(--slate-300);background:var(--slate-50); }
.btn-sm { font-size:12px;padding:5px 12px; }
.tab-btn { padding:4px 14px;border-radius:20px;font-size:12px;font-weight:600;cursor:pointer;border:1.5px solid var(--slate-200,#e2e8f0);background:#fff;color:var(--slate-500,#64748b);transition:all .15s; }
.tab-btn.active-all{background:#e0f2fe;border-color:#38bdf8;color:#0284c7;}
.tab-btn.active-ibu{background:#f3e8ff;border-color:#a78bfa;color:#7c3aed;}
.tab-btn.active-balita{background:#dbeafe;border-color:#93c5fd;color:#2563eb;}
.donut-wrap { display:flex;flex-direction:column;align-items:center;gap:14px;padding:14px 16px; }
.donut-canvas-wrap { width:160px;height:160px;position:relative; }
.legend-list { width:100%;display:flex;flex-direction:column;gap:7px; }
.legend-row { display:flex;align-items:center;gap:7px; }
.legend-dot { width:9px;height:9px;border-radius:2px;flex-shrink:0; }
.legend-label { font-size:12px;color:var(--slate-600,#475569);flex:1; }
.legend-val { font-size:12px;font-weight:700;color:var(--slate-700); }
.legend-pct { font-size:11px;color:var(--slate-400); }
.apexcharts-custom-tooltip {
  padding: 8px 10px;
  border-radius: 6px;
  background: rgba(15, 23, 42, 0.95) !important;
  color: #fff !important;
  font-size: 12px;
  font-family: 'DM Sans', sans-serif;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
  border: 1px solid rgba(255, 255, 255, 0.1) !important;
}
.apexcharts-canvas {
  margin: 0 auto;
}
/* dashboard-stats-grid and dashboard-chart-grid are now defined globally in layouts/app.blade.php */
.dashboard-bottom-grid { display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:16px;margin-bottom:20px; }
.dashboard-card-header-actions { display:flex;align-items:center;gap:10px;flex-wrap:wrap; }
.tab-filter { display:flex;gap:6px;flex-wrap:wrap; }
.dashboard-table-wrap { overflow-x:auto;-webkit-overflow-scrolling:touch; }
.dashboard-table-wrap .data-table { min-width:580px; }
@keyframes pulse { 0%,100%{opacity:1;transform:scale(1);} 50%{opacity:.5;transform:scale(1.3);} }

@media (max-width: 767px) {
  /* Pemeriksaan Terbaru header layout on mobile: Title (left) & Lihat Semua (right), Tabs below */
  .card:has(#tablePemeriksaan) .card-header {
    display: grid !important;
    grid-template-areas: 
      "title action"
      "tabs tabs" !important;
    grid-template-columns: 1fr auto !important;
    gap: 12px 8px !important;
    align-items: center !important;
    padding: 12px 14px !important;
  }
  
  .card:has(#tablePemeriksaan) .card-header > div:first-child {
    grid-area: title !important;
  }
  
  .card:has(#tablePemeriksaan) .card-header .dashboard-card-header-actions {
    display: contents !important;
  }
  
  .card:has(#tablePemeriksaan) .card-header .tab-filter {
    grid-area: tabs !important;
    display: flex !important;
    width: 100% !important;
    justify-content: space-between !important;
    gap: 6px !important;
  }
  
  .card:has(#tablePemeriksaan) .card-header .tab-filter .tab-btn {
    flex: 1 !important;
    text-align: center !important;
    padding: 6px 4px !important;
    font-size: 11.5px !important;
  }
  
  .card:has(#tablePemeriksaan) .card-header .btn {
    grid-area: action !important;
    justify-self: end !important;
    margin: 0 !important;
    padding: 6px 12px !important;
    font-size: 11.5px !important;
    white-space: nowrap !important;
  }
}
</style>
@endpush

@section('content')

<div class="welcome-banner">
  <div>
    <div style="font-size:18px;font-weight:800;">Halo, {{ auth()->user()->nama }}</div>
    <div style="font-size:12px;color:rgba(255,255,255,.75);margin-top:3px;">
      Pantau dan kelola seluruh data kesehatan ibu hamil & balita Posyandu Melati 2.
    </div>
  </div>
  <div style="margin-left:auto;">
    <form method="GET" action="{{ route('ketua.dashboard') }}">
      <div class="dp-box" onclick="this.querySelector('input[type=date]').showPicker()"
          style="cursor:pointer;" title="Klik untuk ganti tanggal">
        <div>
          <div style="font-size:18px;font-weight:800;color:#fff;line-height:1;">
            {{ \Carbon\Carbon::parse($tanggal)->format('d') }}
          </div>
          <div style="font-size:10px;color:rgba(255,255,255,.75);font-weight:600;">
            {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('F Y') }}
          </div>
        </div>
        <div style="font-size:11px;color:rgba(255,255,255,.6);margin-top:2px;">
          <i class="fas fa-calendar-alt"></i>
        </div>
        <input type="date"
              name="tanggal"
              value="{{ $tanggal }}"
              onchange="this.form.submit()"
              style="position:absolute;opacity:0;width:0;height:0;pointer-events:none;">
      </div>
    </form>
  </div>
</div>

<div class="dashboard-stats-grid">
  <div class="stat-card card-teal">
    <div class="stat-icon icon-teal"><i class="fas fa-person-pregnant"></i></div>
    <div class="stat-value">{{ $totalIbuHamil }}</div>
    <div class="stat-label">Total Ibu Hamil</div>
    <div class="stat-delta delta-up"><i class="fas fa-arrow-up"></i> Terdaftar aktif</div>
  </div>
  <div class="stat-card card-rose">
    <div class="stat-icon icon-rose"><i class="fas fa-baby"></i></div>
    <div class="stat-value">{{ $totalBalita ?? 0 }}</div>
    <div class="stat-label">Total Balita</div>
    <div class="stat-delta delta-up"><i class="fas fa-arrow-up"></i> Terdaftar aktif</div>
  </div>
  <div class="stat-card card-amber">
    <div class="stat-icon icon-amber"><i class="fas fa-calendar-check"></i></div>
    <div class="stat-value">{{ $pemeriksaanBulanIni ?? 0 }}</div>
    <div class="stat-label">Pemeriksaan Bulan Ini</div>
    <div class="stat-delta" style="color:var(--slate-400);">{{ now()->translatedFormat('F Y') }}</div>
  </div>
  <div class="stat-card card-green">
    <div class="stat-icon icon-green"><i class="fas fa-stethoscope"></i></div>
    <div class="stat-value">{{ $pemeriksaanHariIni ?? 0 }}</div>
    <div class="stat-label">Pemeriksaan Hari Ini</div>
    <div class="stat-delta" style="color:var(--slate-400);">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</div>
  </div>
  <div class="stat-card card-indigo">
    <div class="stat-icon icon-indigo"><i class="fas fa-users"></i></div>
    <div class="stat-value">{{ $totalUser ?? 0 }}</div>
    <div class="stat-label">Total Pengguna</div>
    <div class="stat-delta" style="color:var(--slate-400);">Ketua Posyandu + Kader + Bidan</div>
  </div>
</div>

<div class="dashboard-chart-grid">
  <div class="card">
    <div class="card-header">
      <div>
        <div class="card-title" style="display:flex;align-items:center;gap:7px;">
          <span style="width:10px;height:10px;border-radius:3px;background:#14a398;display:inline-block;"></span>
          Pemeriksaan Ibu Hamil
        </div>
        <div class="card-subtitle">6 bulan terakhir</div>
      </div>
      <div style="text-align:right;">
        <div style="font-size:20px;font-weight:800;color:#14a398;line-height:1;">{{ array_sum($chartIbuHamil) }}</div>
        <div style="font-size:11px;color:var(--slate-400);">Total 6 bulan</div>
      </div>
    </div>
    <div style="padding:14px 16px;"><canvas id="chartIbuHamil" height="160"></canvas></div>
  </div>
  <div class="card">
    <div class="card-header">
      <div>
        <div class="card-title" style="display:flex;align-items:center;gap:7px;">
          <span style="width:10px;height:10px;border-radius:3px;background:#f43f5e;display:inline-block;"></span>
          Pemeriksaan Balita
        </div>
        <div class="card-subtitle">6 bulan terakhir</div>
      </div>
      <div style="text-align:right;">
        <div style="font-size:20px;font-weight:800;color:#f43f5e;line-height:1;">{{ array_sum($chartBalita) }}</div>
        <div style="font-size:11px;color:var(--slate-400);">Total 6 bulan</div>
      </div>
    </div>
    <div style="padding:14px 16px;"><canvas id="chartBalita" height="160"></canvas></div>
  </div>
</div>

<div class="dashboard-bottom-grid">
  <div class="card">
    <div class="card-header">
      <div><div class="card-title">Status Gizi Balita</div><div class="card-subtitle">Distribusi keseluruhan</div></div>
    </div>
    <div class="donut-wrap">
      <div class="donut-canvas-wrap"><div id="chartGizi" style="width: 100%; height: 100%;"></div></div>
      <div class="legend-list">
        @php
          $totalGizi = ($giziNormal??0)+($giziKurang??0)+($giziBuruk??0)+($giziLebih??0);
          $giziRows = [
            ['label'=>'Gizi Baik / Normal','val'=>$giziNormal??0,'color'=>'#22c55e'],
            ['label'=>'Gizi Kurang','val'=>$giziKurang??0,'color'=>'#f59e0b'],
            ['label'=>'Berisiko Stunting','val'=>$giziBuruk??0,'color'=>'#ef4444'],
            ['label'=>'Gizi Lebih','val'=>$giziLebih??0,'color'=>'#6366f1'],
          ];
        @endphp
        @foreach($giziRows as $g)
        <div class="legend-row">
          <span class="legend-dot" style="background:{{ $g['color'] }};"></span>
          <span class="legend-label">{{ $g['label'] }}</span>
          <span class="legend-val">{{ $g['val'] }}</span>
          <span class="legend-pct">({{ $totalGizi > 0 ? round($g['val']/$totalGizi*100) : 0 }}%)</span>
        </div>
        @endforeach
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <div><div class="card-title">Trimester Ibu Hamil</div><div class="card-subtitle">Distribusi keseluruhan</div></div>
    </div>
    <div class="donut-wrap">
      <div class="donut-canvas-wrap"><div id="chartTrimester" style="width: 100%; height: 100%;"></div></div>
      <div class="legend-list">
        @php
          $totalTrimester = ($trimester1??0)+($trimester2??0)+($trimester3??0);
          $trimesterRows = [
            ['label'=>'Trimester 1 (≤12 minggu)','val'=>$trimester1??0,'color'=>'#14a398'],
            ['label'=>'Trimester 2 (13-27 minggu)','val'=>$trimester2??0,'color'=>'#6366f1'],
            ['label'=>'Trimester 3 (≥28 minggu)','val'=>$trimester3??0,'color'=>'#f59e0b'],
          ];
        @endphp
        @foreach($trimesterRows as $t)
        <div class="legend-row">
          <span class="legend-dot" style="background:{{ $t['color'] }};"></span>
          <span class="legend-label">{{ $t['label'] }}</span>
          <span class="legend-val">{{ $t['val'] }}</span>
          <span class="legend-pct">({{ $totalTrimester > 0 ? round($t['val']/$totalTrimester*100) : 0 }}%)</span>
        </div>
        @endforeach
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <div><div class="card-title">Status Pemeriksaan</div><div class="card-subtitle">Bulan {{ now()->translatedFormat('F Y') }}</div></div>
    </div>
    <div style="padding:18px 20px;display:flex;flex-direction:column;gap:24px;">
      @php
        $totalIbuStatus    = ($ibuSudahBidan??0)+($ibuBelumBidan??0);
        $totalBalitaStatus = ($balitaSudahBidan??0)+($balitaBelumBidan??0);
        $pctIbuSudah  = $totalIbuStatus    > 0 ? round(($ibuSudahBidan??0)/$totalIbuStatus*100)       : 0;
        $pctIbuBelum  = $totalIbuStatus    > 0 ? round(($ibuBelumBidan??0)/$totalIbuStatus*100)       : 0;
        $pctBalSudah  = $totalBalitaStatus > 0 ? round(($balitaSudahBidan??0)/$totalBalitaStatus*100) : 0;
        $pctBalBelum  = $totalBalitaStatus > 0 ? round(($balitaBelumBidan??0)/$totalBalitaStatus*100) : 0;
      @endphp
      <div>
        <div style="font-size:12px;font-weight:700;color:var(--slate-600);margin-bottom:10px;display:flex;align-items:center;gap:6px;">
          <i class="fas fa-person-pregnant" style="color:#14a398;"></i> Ibu Hamil
        </div>
        <div style="display:flex;flex-direction:column;gap:8px;">
          <div>
            <div style="display:flex;justify-content:space-between;margin-bottom:4px;">
              <span style="font-size:12px;color:var(--slate-600);">Awal & Lanjutan</span>
              <span style="font-size:12px;font-weight:700;">{{ $ibuSudahBidan??0 }}</span>
            </div>
            <div style="height:6px;background:#e2e8f0;border-radius:4px;overflow:hidden;">
              <div style="height:100%;background:#22c55e;border-radius:4px;width:{{ $pctIbuSudah }}%;"></div>
            </div>
          </div>
          <div>
            <div style="display:flex;justify-content:space-between;margin-bottom:4px;">
              <span style="font-size:12px;color:var(--slate-600);">Baru Pemeriksaan Awal</span>
              <span style="font-size:12px;font-weight:700;">{{ $ibuBelumBidan??0 }}</span>
            </div>
            <div style="height:6px;background:#e2e8f0;border-radius:4px;overflow:hidden;">
              <div style="height:100%;background:#f59e0b;border-radius:4px;width:{{ $pctIbuBelum }}%;"></div>
            </div>
          </div>
        </div>
      </div>
      <div style="border-top:1px solid var(--slate-100);"></div>
      <div>
        <div style="font-size:12px;font-weight:700;color:var(--slate-600);margin-bottom:10px;display:flex;align-items:center;gap:6px;">
          <i class="fas fa-baby" style="color:#6366f1;"></i> Balita
        </div>
        <div style="display:flex;flex-direction:column;gap:8px;">
          <div>
            <div style="display:flex;justify-content:space-between;margin-bottom:4px;">
              <span style="font-size:12px;color:var(--slate-600);">Awal & Lanjutan</span>
              <span style="font-size:12px;font-weight:700;">{{ $balitaSudahBidan??0 }}</span>
            </div>
            <div style="height:6px;background:#e2e8f0;border-radius:4px;overflow:hidden;">
              <div style="height:100%;background:#22c55e;border-radius:4px;width:{{ $pctBalSudah }}%;"></div>
            </div>
          </div>
          <div>
            <div style="display:flex;justify-content:space-between;margin-bottom:4px;">
              <span style="font-size:12px;color:var(--slate-600);">Baru Pemeriksaan Awal</span>
              <span style="font-size:12px;font-weight:700;">{{ $balitaBelumBidan??0 }}</span>
            </div>
            <div style="height:6px;background:#e2e8f0;border-radius:4px;overflow:hidden;">
              <div style="height:100%;background:#f59e0b;border-radius:4px;width:{{ $pctBalBelum }}%;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <div><div class="card-title">Pemeriksaan Terbaru</div><div class="card-subtitle">10 data terakhir (ibu hamil & balita)</div></div>
    <div class="dashboard-card-header-actions">
      <div class="tab-filter">
        <button class="tab-btn active-all" onclick="filterTable('all',this)" data-active="active-all">Semua</button>
        <button class="tab-btn" onclick="filterTable('ibu_hamil',this)" data-active="active-ibu">Ibu Hamil</button>
        <button class="tab-btn" onclick="filterTable('balita',this)" data-active="active-balita">Balita</button>
      </div>
      <a href="{{ route('ketua.laporan.ibu-hamil') }}" class="btn btn-outline btn-sm">
        <i class="fas fa-arrow-right"></i> Lihat Semua
      </a>
    </div>
  </div>
  <div class="dashboard-table-wrap">
    <table class="data-table" id="tablePemeriksaan">
      <thead>
        <tr>
          <th style="text-align:left;">Nama</th>
          <th>Kategori</th><th>Tanggal Periksa</th><th>Kader Pemeriksa</th><th>Bidan Pemeriksa</th><th>Status</th>
        </tr>
      </thead>
      <tbody>
        @forelse($pemeriksaanTerbaru ?? [] as $item)
        <tr data-jenis="{{ $item->jenis }}">
          <td>
            <div class="cell-with-avatar">
              <div class="avatar-table" style="background:{{ $item->jenis === 'ibu_hamil' ? 'linear-gradient(135deg,#14a398,#0f8075)' : 'linear-gradient(135deg,#6366f1,#4f46e5)' }}">
                {{ strtoupper(substr($item->nama, 0, 1)) }}
              </div>
              <div>
                <div class="cell-name">{{ $item->nama }}</div>
                <div class="cell-meta">{{ $item->jenis === 'ibu_hamil' ? 'Usia Kehamilan' : 'Usia' }}: {{ $item->usia ?? '-' }}</div>
              </div>
            </div>
          </td>
          <td><span class="badge {{ $item->jenis === 'ibu_hamil' ? 'badge-purple' : 'badge-blue' }}">{{ $item->jenis === 'ibu_hamil' ? 'Ibu Hamil' : 'Balita' }}</span></td>
          <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>
          <td>{{ $item->pemeriksa ?? '-' }}</td>
          <td>
            @if(!empty($item->bidan))
              {{ $item->bidan }}
            @else
              <span style="color:var(--slate-400);font-style:italic;font-size:.8rem;">Belum diperiksa bidan</span>
            @endif
          </td>
          <td>
            @if($item->status === 'selesai') <span class="badge badge-green">Selesai</span>
            @elseif($item->status === 'rujukan') <span class="badge badge-red">Rujukan</span>
            @else <span class="badge badge-orange">Perlu Follow-up</span>
            @endif
          </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;padding:32px;color:var(--slate-400);">
          <i class="fas fa-inbox" style="font-size:24px;margin-bottom:8px;display:block;"></i>Belum ada data pemeriksaan
        </td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const def = {
    responsive:true, maintainAspectRatio:false,
    plugins:{ legend:{display:false}, tooltip:{cornerRadius:8} },
    scales:{ x:{grid:{display:false},ticks:{font:{size:11}}}, y:{beginAtZero:true,ticks:{precision:0,font:{size:11}},grid:{color:'rgba(0,0,0,.05)'}} }
  };
  new Chart(document.getElementById('chartIbuHamil'), {
    type:'line', data:{ labels:{!! json_encode($chartLabels) !!}, datasets:[{data:{!! json_encode($chartIbuHamil) !!},borderColor:'#14a398',borderWidth:2.5,tension:0.4,pointBackgroundColor:'#14a398',pointBorderColor:'#fff',pointBorderWidth:2,pointRadius:5,pointHoverRadius:7,fill:true,backgroundColor:'rgba(20,163,152,0.10)'}] }, options:def
  });
  new Chart(document.getElementById('chartBalita'), {
    type:'line', data:{ labels:{!! json_encode($chartLabels) !!}, datasets:[{data:{!! json_encode($chartBalita) !!},borderColor:'#f43f5e',borderWidth:2.5,tension:0.4,pointBackgroundColor:'#f43f5e',pointBorderColor:'#fff',pointBorderWidth:2,pointRadius:5,pointHoverRadius:7,fill:true,backgroundColor:'rgba(244,63,94,0.10)'}] }, options:def
  });

  // ApexCharts: Status Gizi Balita Donut Chart
  const optionsGizi = {
    chart: {
      type: 'donut',
      height: 160,
      width: 160,
      animations: {
        enabled: true,
        easing: 'easeinout',
        speed: 800,
        animateGradually: {
          enabled: true,
          delay: 150
        },
        dynamicAnimation: {
          enabled: true,
          speed: 350
        }
      },
      dropShadow: {
        enabled: true,
        blur: 5,
        color: '#0f172a',
        opacity: 0.08,
        left: 0,
        top: 3
      }
    },
    series: [{{ $giziNormal??0 }}, {{ $giziKurang??0 }}, {{ $giziBuruk??0 }}, {{ $giziLebih??0 }}],
    labels: ['Gizi Baik / Normal', 'Gizi Kurang', 'Berisiko Stunting', 'Gizi Lebih'],
    colors: ['#22c55e', '#f59e0b', '#ef4444', '#6366f1'],
    stroke: {
      show: true,
      width: 2,
      colors: ['#ffffff']
    },
    plotOptions: {
      pie: {
        expandOnClick: true,
        donut: {
          size: '72%',
          labels: {
            show: true,
            name: {
              show: true,
              fontSize: '11px',
              fontFamily: 'DM Sans, sans-serif',
              color: '#94a3b8',
              offsetY: -4
            },
            value: {
              show: true,
              fontSize: '18px',
              fontFamily: 'DM Sans, sans-serif',
              fontWeight: '800',
              color: '#1e293b',
              offsetY: 4,
              formatter: function (val) {
                return val;
              }
            },
            total: {
              show: true,
              label: 'Total',
              color: '#94a3b8',
              fontSize: '11px',
              fontFamily: 'DM Sans, sans-serif',
              fontWeight: '600',
              formatter: function (w) {
                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
              }
            }
          }
        }
      }
    },
    dataLabels: {
      enabled: false
    },
    legend: {
      show: false
    },
    tooltip: {
      enabled: true,
      y: {
        formatter: function (val) {
          return val + " Balita";
        }
      }
    },
    responsive: [{
      breakpoint: 769,
      options: {
        chart: {
          width: 130,
          height: 130
        }
      }
    }]
  };
  const chartGizi = new ApexCharts(document.querySelector("#chartGizi"), optionsGizi);
  chartGizi.render();

  // ApexCharts: Trimester Ibu Hamil Donut Chart (sama dengan Gizi Balita)
  const optionsTrimester = {
    chart: {
      type: 'donut',
      height: 160,
      width: 160,
      animations: {
        enabled: true,
        easing: 'easeinout',
        speed: 800,
        animateGradually: {
          enabled: true,
          delay: 150
        },
        dynamicAnimation: {
          enabled: true,
          speed: 350
        }
      },
      dropShadow: {
        enabled: true,
        blur: 5,
        color: '#0f172a',
        opacity: 0.08,
        left: 0,
        top: 3
      }
    },
    series: [{{ $trimester1??0 }}, {{ $trimester2??0 }}, {{ $trimester3??0 }}],
    labels: ['Trimester 1', 'Trimester 2', 'Trimester 3'],
    colors: ['#14a398', '#6366f1', '#f59e0b'],
    stroke: {
      show: true,
      width: 2,
      colors: ['#ffffff']
    },
    plotOptions: {
      pie: {
        expandOnClick: true,
        donut: {
          size: '72%',
          labels: {
            show: true,
            name: {
              show: true,
              fontSize: '11px',
              fontFamily: 'DM Sans, sans-serif',
              color: '#94a3b8',
              offsetY: -4
            },
            value: {
              show: true,
              fontSize: '18px',
              fontFamily: 'DM Sans, sans-serif',
              fontWeight: '800',
              color: '#1e293b',
              offsetY: 4,
              formatter: function (val) {
                return val;
              }
            },
            total: {
              show: true,
              label: 'Total',
              color: '#94a3b8',
              fontSize: '11px',
              fontFamily: 'DM Sans, sans-serif',
              fontWeight: '600',
              formatter: function (w) {
                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
              }
            }
          }
        }
      }
    },
    dataLabels: {
      enabled: false
    },
    legend: {
      show: false
    },
    tooltip: {
      enabled: true,
      y: {
        formatter: function (val) {
          return val + " Ibu";
        }
      }
    },
    responsive: [{
      breakpoint: 769,
      options: {
        chart: {
          width: 130,
          height: 130
        }
      }
    }]
  };
  const chartTrimester = new ApexCharts(document.querySelector("#chartTrimester"), optionsTrimester);
  chartTrimester.render();

  let countdown = 300;
  const indicator = document.getElementById('refreshIndicator');

  function updateCountdown() {
    if (indicator) indicator.textContent = 'Refresh dalam ' + countdown + 'd';
    countdown--;
    if (countdown < 0) location.reload();
  }

  updateCountdown();
  setInterval(updateCountdown, 1000);
});

function filterTable(jenis, btn) {
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active-all','active-ibu','active-balita'));
  btn.classList.add(btn.dataset.active);
  document.querySelectorAll('#tablePemeriksaan tbody tr[data-jenis]').forEach(r => {
    r.style.display = (jenis === 'all' || r.dataset.jenis === jenis) ? '' : 'none';
  });
}
</script>
@endpush