@extends('layouts.app')
@section('title', 'Dashboard Kader — Posyandu Melati 2')
@section('page_title', 'Dashboard Kader')

@push('styles')
<style>
:root{--teal:#14a398;--rose:#f43f5e;--amber:#f59e0b;}
.stat-card{background:#fff;border-radius:12px;padding:14px 16px 12px;box-shadow:0 1px 4px rgba(0,0,0,.06);border-top:3px solid transparent;transition:box-shadow .15s,transform .15s;}
.stat-card:hover{transform:translateY(-2px);box-shadow:0 5px 15px rgba(0,0,0,.09);}
.card-teal{border-top-color:var(--teal);}.card-rose{border-top-color:var(--rose);}.card-amber{border-top-color:var(--amber);}
.stat-icon{width:34px;height:34px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:15px;margin-bottom:8px;}
.icon-teal{background:#e6f7f6;color:var(--teal);}.icon-rose{background:#ffeef2;color:var(--rose);}.icon-amber{background:#fef3e2;color:var(--amber);}
.stat-value{font-size:24px;font-weight:800;color:#1e293b;line-height:1;}
.stat-label{font-size:12px;color:#64748b;margin-top:3px;}
.stat-delta{font-size:11px;margin-top:4px;color:#64748b;}
.card{background:#fff;border-radius:12px;box-shadow:0 1px 4px rgba(0,0,0,.06);overflow:hidden;}
.card-header{display:flex;align-items:center;justify-content:space-between;padding:11px 14px 10px;border-bottom:1px solid #f1f5f9;}
.card-title{font-size:13px;font-weight:700;color:#1e293b;display:flex;align-items:center;gap:6px;}
.card-subtitle{font-size:10px;color:#94a3b8;margin-top:1px;}
.data-table{width:100%;border-collapse:collapse;font-size:12px;}
.data-table thead th{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:#94a3b8;padding:8px 10px;background:#f8fafc;border-bottom:1px solid #f1f5f9;text-align:center;white-space:nowrap;}
.data-table thead th:nth-child(2){text-align:left;}
.data-table tbody td{padding:8px 10px;border-bottom:1px solid #f8fafc;vertical-align:middle;text-align:center;color:#334155;}
.data-table tbody td:nth-child(2){text-align:left;}
.data-table tbody tr:last-child td{border-bottom:none;}
.data-table tbody tr:hover td{background:#fafbff;}
.cell-name{font-weight:600;font-size:12px;color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:130px;}
.cell-meta{font-size:11px;color:#94a3b8;margin-top:1px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:130px;}
.badge{display:inline-block;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:600;white-space:nowrap;}
.badge-purple{background:#f3e8ff;color:#7c3aed;}.badge-green{background:#dcfce7;color:#16a34a;}
.badge-orange{background:#ffedd5;color:#ea580c;}.badge-red{background:#fee2e2;color:#dc2626;}
.dp-box{display:flex;align-items:center;gap:8px;background:rgba(255,255,255,.13);border:1.5px solid rgba(255,255,255,.28);border-radius:12px;padding:8px 14px;backdrop-filter:blur(8px);}
.welcome-banner{background:linear-gradient(135deg,#0a3d39,#0f766e 50%,#14b8a6);border-radius:16px;padding:20px 24px;color:#fff;margin-bottom:16px;display:flex;align-items:center;gap:16px;}
.grid-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:16px;}
.grid-charts{display:grid;grid-template-columns:1fr 1fr 240px;gap:12px;margin-bottom:16px;}
.chart-wrap{height:200px;position:relative;}
.grid-tables{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
@media(max-width:1400px){.grid-charts{grid-template-columns:1fr 1fr 220px;}}
@media(max-width:1200px){
  .grid-charts{grid-template-columns:1fr 1fr;grid-template-rows:auto auto;}
  .grid-charts .card:last-child{grid-column:1/-1;display:flex;flex-direction:row;align-items:center;gap:16px;padding:4px;}
  .grid-charts .card:last-child canvas{max-width:110px;max-height:110px;}
  .cell-name{max-width:100px;}.cell-meta{max-width:100px;}
}
@media(max-width:1024px){
  .grid-stats{grid-template-columns:repeat(3,1fr);}
  .grid-charts{grid-template-columns:1fr;}
  .grid-charts .card:last-child{grid-column:auto;flex-direction:column;}
  .grid-tables{grid-template-columns:1fr;}
}
</style>
@endpush

@section('content')

<div class="welcome-banner">
  <div>
    <div style="font-size:18px;font-weight:800;">Halo, {{ auth()->user()->nama }}</div>
    <div style="font-size:12px;color:rgba(255,255,255,.75);margin-top:3px;">Semangat bertugas hari ini ~ pantau kesehatan warga dengan teliti.</div>
  </div>
    <div style="margin-left:auto;">
      <form method="GET" action="{{ route('kader.dashboard') }}">
        <div class="dp-box" onclick="this.querySelector('input[type=date]').showPicker()"
            style="cursor:pointer;position:relative;" title="Klik untuk ganti tanggal">
          <div>
            <div style="font-size:18px;font-weight:800;color:#fff;line-height:1;">
              {{ \Carbon\Carbon::parse($tanggal)->format('d') }}
            </div>
            <div style="font-size:10px;color:rgba(255,255,255,.75);font-weight:600;">
              {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('F Y') }}
            </div>
          </div>
          <i class="fas fa-calendar-alt" style="font-size:13px;color:rgba(255,255,255,.6);"></i>
          <input type="date"
                name="tanggal"
                value="{{ $tanggal }}"
                onchange="this.form.submit()"
                style="position:absolute;opacity:0;width:0;height:0;pointer-events:none;">
        </div>
      </form>
    </div>
</div>

@php
  $ibuPct    = $totalIbuHamil > 0 ? round($ibuSudahDiperiksa/$totalIbuHamil*100) : 0;
  $balitaPct = $totalBalita   > 0 ? round($balitaSudahDiperiksa/$totalBalita*100) : 0;
@endphp

<div class="grid-stats">
  <div class="stat-card card-teal">
    <div class="stat-icon icon-teal"><i class="fas fa-person-pregnant"></i></div>
    <div class="stat-value">{{ $totalIbuHamil }}</div>
    <div class="stat-label">Ibu Hamil Terdaftar</div>
    <div class="stat-delta"><i class="fas fa-check" style="color:var(--teal);"></i> {{ $ibuSudahDiperiksa }} diperiksa ({{ $ibuPct }}%)</div>
  </div>
  <div class="stat-card card-rose">
    <div class="stat-icon icon-rose"><i class="fas fa-baby"></i></div>
    <div class="stat-value">{{ $totalBalita }}</div>
    <div class="stat-label">Balita Terdaftar</div>
    <div class="stat-delta"><i class="fas fa-check" style="color:var(--rose);"></i> {{ $balitaSudahDiperiksa }} diperiksa ({{ $balitaPct }}%)</div>
  </div>
  <div class="stat-card card-amber">
    <div class="stat-icon icon-amber"><i class="fas fa-clipboard-check"></i></div>
    <div class="stat-value">{{ $pemeriksaanHariIni }}</div>
    <div class="stat-label">Total Pemeriksaan</div>
    <div class="stat-delta">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</div>
  </div>
</div>

<div class="grid-charts">
  <div class="card">
    <div class="card-header"><div><div class="card-title"><span style="width:9px;height:9px;border-radius:3px;background:var(--teal);display:inline-block;"></span>Pemeriksaan Ibu Hamil</div><div class="card-subtitle">6 bulan terakhir</div></div></div>
    <div style="padding:10px 14px;"><div class="chart-wrap"><canvas id="chartIbu"></canvas></div></div>
  </div>
  <div class="card">
    <div class="card-header"><div><div class="card-title"><span style="width:9px;height:9px;border-radius:3px;background:var(--rose);display:inline-block;"></span>Pemeriksaan Balita</div><div class="card-subtitle">6 bulan terakhir</div></div></div>
    <div style="padding:10px 14px;"><div class="chart-wrap"><canvas id="chartBalita"></canvas></div></div>
  </div>
  <div class="card">
    <div class="card-header"><div><div class="card-title">Status Gizi Balita</div><div class="card-subtitle">Distribusi keseluruhan</div></div></div>
    <div style="padding:10px 14px;display:flex;flex-direction:column;align-items:center;gap:8px;">
      <div style="position:relative;width:100px;height:100px;flex-shrink:0;"><canvas id="chartGizi"></canvas></div>
      @php
        $totalGizi = ($giziNormal??0)+($giziKurang??0)+($giziBuruk??0)+($giziLebih??0);
        $giziRows  = [['Gizi Baik / Normal',$giziNormal??0,'#22c55e'],['Gizi Kurang',$giziKurang??0,'#f59e0b'],['Berisiko Stunting',$giziBuruk??0,'#ef4444'],['Gizi Lebih',$giziLebih??0,'#6366f1']];
      @endphp
      <div style="width:100%;display:flex;flex-direction:column;gap:5px;">
        @foreach($giziRows as [$lbl,$val,$clr])
        <div style="display:flex;align-items:center;gap:6px;">
          <span style="width:8px;height:8px;border-radius:2px;background:{{$clr}};flex-shrink:0;"></span>
          <span style="font-size:11px;color:#475569;flex:1;">{{$lbl}}</span>
          <span style="font-size:11px;font-weight:700;color:#334155;">{{$val}}</span>
          <span style="font-size:10px;color:#94a3b8;">({{ $totalGizi>0?round($val/$totalGizi*100):0 }}%)</span>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

<div class="grid-tables">
  <div class="card">
    <div class="card-header">
      <div><div class="card-title"><i class="fas fa-person-pregnant" style="color:var(--teal);font-size:12px;"></i> Pemeriksaan Ibu Hamil</div><div class="card-subtitle">Data terbaru</div></div>
      <span class="badge badge-purple">{{ $pemeriksaanIbu->count() }} data</span>
    </div>
    <div class="table-scroll">
    <table class="data-table">
        <thead><tr><th>No</th><th>Nama Ibu</th><th>Tanggal Periksa</th><th>Status</th><th>BB / TD</th><th>Kader</th><th>Status</th></tr></thead>      <tbody>
        @forelse($pemeriksaanIbu as $i => $p)
          <tr>
            <td>{{$i+1}}</td>
            <td><div class="cell-name">{{$p->ibuHamil->nama_ibu}}</div><div class="cell-meta">NIK: {{$p->ibuHamil->nik}}</div></td>
            <td>{{ \Carbon\Carbon::parse($p->tanggal_periksa)->translatedFormat('d M Y') }}</td>
            <td><span class="badge badge-purple">G{{$p->ibuHamil->gravida}}P{{$p->ibuHamil->partus}}A{{$p->ibuHamil->abortus}}</span><div class="cell-meta">{{$p->usia_kehamilan}} mgg</div></td>
            <td><div class="cell-name">{{fmtAngka($p->berat_badan)}} kg</div><div class="cell-meta">{{$p->tekanan_darah}}</div></td>
            <td><span style="font-size:11px;color:#334155;">{{$p->kader->nama??'-'}}</span></td>
            <td>@if($p->status=='Menunggu Bidan')<span class="badge badge-orange">Menunggu Bidan</span>@else<span class="badge badge-green">Selesai</span>@endif</td>
          </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;padding:20px;color:#94a3b8;"><i class="fas fa-inbox" style="display:block;font-size:20px;margin-bottom:4px;"></i>Belum ada data</td></tr>
        @endforelse
      </tbody>
    </table>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <div><div class="card-title"><i class="fas fa-baby" style="color:var(--rose);font-size:12px;"></i> Pemeriksaan Balita</div><div class="card-subtitle">Data terbaru</div></div>
      <span class="badge" style="background:#ffeef2;color:var(--rose);">{{ $pemeriksaanBalita->count() }} data</span>
    </div>
    <div class="table-scroll">
    <table class="data-table">
        <thead><tr><th>No</th><th>Nama Balita</th><th>Tanggal Periksa</th><th>Usia</th><th>BB / TB</th><th>Kader</th><th>Status Gizi</th></tr></thead>      <tbody>
        @forelse($pemeriksaanBalita as $i => $b)
        @php
          $gz = optional($b->pemeriksaanLanjutan)->status_gizi ?? '-';
          $gzBadge = str_contains(strtolower($gz),'baik')||str_contains(strtolower($gz),'normal') ? 'badge-green'
            : (str_contains(strtolower($gz),'lebih') ? 'badge-blue'
            : (str_contains(strtolower($gz),'kurang') ? 'badge-orange'
            : (str_contains(strtolower($gz),'buruk')||str_contains(strtolower($gz),'stunting') ? 'badge-red' : 'badge-teal')));
        @endphp
          <tr>
            <td>{{$i+1}}</td>
            <td><div class="cell-name">{{$b->balita->nama_balita}}</div><div class="cell-meta">{{ $b->balita->ibuHamil->nama_ibu ?? $b->balita->nama_ibu ?? '-' }}</div></td>
            <td>{{ \Carbon\Carbon::parse($b->tanggal_periksa)->translatedFormat('d M Y') }}</td>
            <td><div class="cell-name">{{$b->usia_balita??'-'}} bln</div><div class="cell-meta">{{ $b->balita->jenis_kelamin == 'L' ? 'Laki-laki' : ($b->balita->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</div></td>
            <td><div class="cell-name">{{fmtAngka($b->berat_badan)}} kg</div><div class="cell-meta">{{fmtAngka($b->tinggi_badan ?? null)}} cm</div></td>
            <td><span style="font-size:11px;color:#334155;">{{$b->kader->nama??'-'}}</span></td>
            <td><span class="badge {{$gzBadge}}">{{$gz}}</span></td>
          </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;padding:20px;color:#94a3b8;"><i class="fas fa-inbox" style="display:block;font-size:20px;margin-bottom:4px;"></i>Belum ada data</td></tr>
        @endforelse
      </tbody>
    </table>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const opt={responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false},tooltip:{cornerRadius:6}},scales:{x:{grid:{display:false},ticks:{font:{size:10}}},y:{beginAtZero:true,ticks:{precision:0,font:{size:10}},grid:{color:'rgba(0,0,0,.05)'}}}};
new Chart(document.getElementById('chartIbu'),{type:'line',data:{labels:@json($chartLabels),datasets:[{data:@json($chartIbu),borderColor:'#14a398',borderWidth:2.5,tension:0.4,pointBackgroundColor:'#14a398',pointBorderColor:'#fff',pointBorderWidth:2,pointRadius:5,pointHoverRadius:7,fill:true,backgroundColor:'rgba(20,163,152,0.10)'}]},options:opt});
new Chart(document.getElementById('chartBalita'),{type:'line',data:{labels:@json($chartLabels),datasets:[{data:@json($chartBalita),borderColor:'#f43f5e',borderWidth:2.5,tension:0.4,pointBackgroundColor:'#f43f5e',pointBorderColor:'#fff',pointBorderWidth:2,pointRadius:5,pointHoverRadius:7,fill:true,backgroundColor:'rgba(244,63,94,0.10)'}]},options:opt});
new Chart(document.getElementById('chartGizi'),{type:'doughnut',data:{labels:['Gizi Baik/Normal','Gizi Kurang','Berisiko Stunting','Gizi Lebih'],datasets:[{data:[{{$giziNormal??0}},{{$giziKurang??0}},{{$giziBuruk??0}},{{$giziLebih??0}}],backgroundColor:['#22c55e','#f59e0b','#ef4444','#6366f1'],borderWidth:2,borderColor:'#fff',hoverOffset:4}]},options:{cutout:'68%',plugins:{legend:{display:false},tooltip:{cornerRadius:6}}}});
</script>
@endpush
@endsection