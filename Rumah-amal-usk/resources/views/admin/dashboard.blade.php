<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Kampanye Donasi
        </h2>
    </x-slot>
    <div class="py-12 bg-gradient-to-b from-indigo-50 via-white to-indigo-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container mx-auto bg-white/90 backdrop-blur-lg rounded-2xl shadow-xl border border-indigo-100 overflow-hidden">
                <div class="header px-8 py-6 border-b border-slate-200 bg-gradient-to-r from-white to-slate-50">
                    <h1 class="text-2xl font-bold text-slate-900 mb-2">Dashboard Kampanye</h1>
                    <p class="text-slate-500">Pantau progress dan kelola donasi secara real-time</p>
                </div>
                <!-- Campaign Cards (Circle Progress) Section -->
                <div class="section px-8 pt-4 pb-10">
                    <h2 class="section-title flex items-center gap-3 mb-8 uppercase font-semibold text-slate-900 text-lg">
                        <span class="inline-block w-1 h-6 rounded bg-gradient-to-b from-blue-500 to-blue-700"></span>
                        <span>Campaign</span>
                        <span class="flex-1 h-px bg-gradient-to-r from-slate-200 to-transparent"></span>
                    </h2>
                    <div id="campaigns-grid" class="campaigns-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                        <div class="campaign-card loading-skeleton" style="height: 265px"></div>
                        <div class="campaign-card loading-skeleton" style="height: 265px"></div>
                        <div class="campaign-card loading-skeleton" style="height: 265px"></div>
                    </div>
                    <div class="expand-container flex justify-end mt-3">
                        <button class="expand-btn" type="button">
                            <span>Lihat Semua Campaign</span>
                            <span>⬇</span>
                        </button>
                    </div>
                </div>
                <!-- Horizontal Bar Chart Section -->
                <div class="section px-8 pt-10 pb-4">
                    <h2 class="section-title flex items-center gap-3 mb-8 uppercase font-semibold text-slate-900 text-lg">
                        <span class="inline-block w-1 h-6 rounded bg-gradient-to-b from-blue-500 to-blue-700"></span>
                        <span>Progress Semua Campaign</span>
                        <span class="flex-1 h-px bg-gradient-to-r from-slate-200 to-transparent"></span>
                    </h2>
                    <div id="barchart-campaigns" class="barchart-campaigns-horizontal"></div>
                </div>
                <!-- Current Donation Section -->
                <div class="section px-8 py-10">
                    <div class="flex flex-wrap justify-between items-center mb-4">
                        <h2 class="section-title flex items-center gap-3 mb-0 uppercase font-semibold text-slate-900 text-lg">
                            <span class="inline-block w-1 h-6 rounded bg-gradient-to-b from-green-500 to-green-700"></span>
                            <span>Current Donation</span>
                            <span class="flex-1 h-px bg-gradient-to-r from-slate-200 to-transparent"></span>
                        </h2>
                        <div>
                            <button id="limit5" class="limit-btn bg-indigo-100 text-indigo-700 font-semibold px-4 py-2 rounded-lg mr-2 focus:outline-none active:bg-indigo-200">5 Terbaru</button>
                            <button id="limit10" class="limit-btn bg-slate-100 text-slate-700 font-semibold px-4 py-2 rounded-lg focus:outline-none active:bg-slate-200">10 Terbaru</button>
                        </div>
                    </div>
                    <div id="donations-list" class="donations-list flex flex-col gap-4">
                        <div class="donation-item loading-skeleton" style="height: 80px"></div>
                        <div class="donation-item loading-skeleton" style="height: 80px"></div>
                        <div class="donation-item loading-skeleton" style="height: 80px"></div>
                        <div class="donation-item loading-skeleton" style="height: 80px"></div>
                        <div class="donation-item loading-skeleton" style="height: 80px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .barchart-campaigns-horizontal {
            width: 100%;
            background: #f8fafc;
            border-radius: 14px;
            box-shadow: 0 1px 6px 0 rgba(0,0,0,0.06);
            padding: 28px 18px 28px 18px;
            margin-bottom: 30px;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }
        .barchart-row-horizontal {
            display: flex;
            align-items: center;
            gap: 16px;
            width: 100%;
            min-height: 38px;
        }
        .barchart-label-horizontal {
            flex: 0 0 165px;
            font-size: 15px;
            color: #444;
            font-weight: 500;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            padding-right: 10px;
        }
        .barchart-bar-horizontal-container {
            flex: 1 1 auto;
            background: #e5e7eb;
            border-radius: 8px;
            height: 22px;
            position: relative;
            overflow: hidden;
            min-width: 90px;
        }
        .barchart-bar-horizontal {
            height: 22px;
            border-radius: 8px;
            transition: width 1.2s cubic-bezier(.4,0,.2,1);
        }
        .barchart-percent-horizontal {
            font-size: 15px;
            width: 54px;
            text-align: right;
            color: #374151;
            font-weight: 600;
            padding-left: 8px;
        }
        @media (max-width: 700px) {
            .barchart-campaigns-horizontal {padding: 10px 2px;}
            .barchart-label-horizontal {flex-basis:80px;font-size:12px;}
            .barchart-percent-horizontal {width:38px;font-size:12px;}
            .barchart-bar-horizontal-container{min-width:50px;}
        }
        .campaigns-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 32px;
        }
        @media (min-width: 640px) { .campaigns-grid { grid-template-columns: repeat(2, 1fr);} }
        @media (min-width: 1024px) { .campaigns-grid { grid-template-columns: repeat(3, 1fr);} }
        .limit-btn.active { background: #6366f1 !important; color: #fff !important; }
        .progress-circle {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto 18px auto;
        }
        .progress-circle svg {
            width: 100%;
            height: 100%;
        }
        .progress-bg {
            fill: none;
            stroke: #f0f0f0;
            stroke-width: 8;
        }
        .progress-bar {
            fill: none;
            stroke-width: 8;
            stroke-linecap: round;
            transform-origin: 80px 80px;
            transition: stroke-dashoffset 1.4s cubic-bezier(.4,0,.2,1);
        }
        .progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 24px;
            color: #222;
            font-weight: bold;
            text-shadow: 0 2px 4px rgba(0,0,0,0.07);
        }
        .campaign-card {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 1px 3px 0 rgba(0,0,0,0.1), 0 1px 2px 0 rgba(0,0,0,0.06);
            border: 1px solid #f1f5f9;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 265px;
        }
        .campaign-name {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            text-align: center;
            margin-bottom: 10px;
        }
        .campaign-stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 16px;
            border-top: 1px solid #f1f5f9;
            font-size: 14px;
            color: #64748b;
            width: 100%;
        }
        @media (max-width: 768px) {
            .campaigns-grid { grid-template-columns: repeat(2, 1fr);}
        }
        @media (max-width: 540px) {
            .campaigns-grid { grid-template-columns: repeat(1, 1fr);}
        }
        .loading-skeleton {
            background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 16px;
        }
        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        .donations-list { display: flex; flex-direction: column; gap: 16px;}
        .donation-item {
            background: white;
            border-radius: 16px;
            padding: 18px 24px;
            box-shadow: 0 1px 3px 0 rgba(0,0,0,0.06), 0 1px 2px 0 rgba(0,0,0,0.04);
            border: 1px solid #f1f5f9;
            display: grid;
            grid-template-columns: 1.8fr 1.2fr 1.4fr 1.1fr;
            gap: 18px;
            align-items: center;
        }
        .donor-info { display: flex; flex-direction: column; gap: 2px;}
        .donor-name { font-size: 16px; font-weight: 600; color: #0f172a;}
        .donor-amount { font-size: 15px; color: #10b981; font-weight: 600;}
        .donation-time { font-size: 13px; color: #64748b;}
        .payment-method {
            background: #eff6ff;
            color: #2563eb;
            padding: 8px 16px;
            border-radius: 12px;
            font-size: 13px; font-weight: 600; text-align: center;
            border: 1px solid #bfdbfe;
            min-width: 90px;
        }
        .campaign-tag {
            background: #f0f9ff;
            color: #0369a1;
            padding: 8px 16px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 500;
            border: 1px solid #bae6fd;
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .status-badge {
            background: #f0fdf4;
            color: #166534;
            padding: 8px 16px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            border: 1px solid #bbf7d0;
            min-width: 80px;
            position: relative;
        }
        .status-badge.notpaid {
            background: #fef9c3;
            color: #b45309;
            border: 1px solid #fde68a;
        }
        .status-badge.failed {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
        @media (max-width: 900px) {
            .donation-item { grid-template-columns: 1.6fr 1fr 1fr 1fr;}
        }
        @media (max-width: 640px) {
            .donation-item { grid-template-columns: 1fr; gap: 6px; text-align: center; padding: 10px;}
            .campaign-tag, .payment-method, .status-badge { margin: 0 auto;}
        }
    </style>

    <script>
    const palette = [
      "#4285f4", "#fbbc05", "#34a853", "#ea4335", "#ff6d01", "#46bdc6",
      "#a142f4", "#f44292", "#2d9cdb", "#ffb800", "#00c48c", "#d7263d"
    ];
    function idToPaletteColor(id) {
        let str = id.toString();
        let hash = 0;
        for (let i = 0; i < str.length; i++) {
            hash = str.charCodeAt(i) + ((hash << 5) - hash);
        }
        let idx = Math.abs(hash) % palette.length;
        return palette[idx];
    }
    function formatRupiah(num) {
        num = parseInt(num) || 0;
        return "Rp " + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    // --- HORIZONTAL BAR CHART ---
    function renderBarChartCampaignsHorizontal(data) {
        const chart = document.getElementById('barchart-campaigns');
        if (!data || !data.length) {
            chart.innerHTML = '<div class="text-center text-gray-400">Tidak ada data campaign.</div>';
            return;
        }
        chart.innerHTML = data.map(d => {
            let acf = d.acf || {};
            let jumlah = parseInt(acf.jumlah_dana) || 0;
            let terkumpul = parseInt(acf.dana_terkumpul) || 0;
            let percent = jumlah > 0 ? Math.min(Math.round(terkumpul / jumlah * 100), 100) : 0;
            let color = idToPaletteColor(d.id);
            let title = d.title?.rendered || '-';
            return `<div class="barchart-row-horizontal">
                <div class="barchart-label-horizontal" title="${title}">${title}</div>
                <div class="barchart-bar-horizontal-container">
                    <div class="barchart-bar-horizontal" style="background:${color};width:0%" data-target="${percent}"></div>
                </div>
                <div class="barchart-percent-horizontal">${percent}%</div>
            </div>`;
        }).join('');
        setTimeout(() => {
            document.querySelectorAll('.barchart-bar-horizontal').forEach(bar => {
                bar.style.width = bar.getAttribute('data-target') + '%';
            });
        }, 180);
    }
    // --- CIRCLE PROGRESS BAR ---
    function renderCampaignCard(data, idx) {
        let title = data.title?.rendered || "-";
        let acf = data.acf || {};
        let jumlah = parseInt(acf.jumlah_dana) || 0;
        let terkumpul = parseInt(acf.dana_terkumpul) || 0;
        let durasi = acf.lama_campaign || "-";
        let percent = jumlah > 0 ? Math.min(Math.round(terkumpul / jumlah * 100), 100) : 0;
        let color = idToPaletteColor(data.id);
        return `
        <div class="campaign-card animate-fade-in">
            <div class="progress-circle" data-percent="${percent}" data-color="${color}">
                <svg viewBox="0 0 160 160">
                    <circle class="progress-bg" cx="80" cy="80" r="70"></circle>
                    <circle class="progress-bar" cx="80" cy="80" r="70" style="stroke: ${color}; transform: rotate(-90deg); transform-origin: 80px 80px;"></circle>
                </svg>
                <div class="progress-text">${percent}%</div>
            </div>
            <div class="campaign-name">${title}</div>
            <div class="campaign-stats">
                <span>Target: ${formatRupiah(jumlah)}</span>
                <span>Lama: ${durasi} hari</span>
            </div>
        </div>`;
    }
    function animateAllCircleBars() {
        document.querySelectorAll('.progress-circle').forEach(function(el){
            var percent = parseFloat(el.getAttribute('data-percent')) || 0;
            var circle = el.querySelector('.progress-bar');
            var totalLength = 2 * Math.PI * 70; // r=70
            var offset = totalLength * (1 - percent/100);
            circle.style.strokeDasharray = totalLength;
            circle.style.strokeDashoffset = totalLength;
            setTimeout(function(){
                circle.style.strokeDashoffset = offset;
            }, 120);
        });
    }
    // --- FETCH CAMPAIGNS ---
    function fetchCampaigns() {
        const grid = document.getElementById('campaigns-grid');
        grid.innerHTML = `<div class="campaign-card loading-skeleton" style="height: 265px"></div>
            <div class="campaign-card loading-skeleton" style="height: 265px"></div>
            <div class="campaign-card loading-skeleton" style="height: 265px"></div>`;
        fetch("https://rumahamal.usk.ac.id/api-staging/wp-json/wp/v2/campaign_unggulan?_fields=id,title,acf")
            .then(res => res.json())
            .then(data => {
                if (!Array.isArray(data) || !data.length) {
                    grid.innerHTML = `<div class="col-span-full text-center text-gray-500 font-semibold py-8">Belum ada campaign unggulan.</div>`;
                    renderBarChartCampaignsHorizontal([]);
                    return;
                }
                grid.setAttribute("data-state", "max3");
                grid.innerHTML = data.slice(0, 3).map(renderCampaignCard).join('');
                grid.dataset.full = JSON.stringify(data);
                setTimeout(animateAllCircleBars, 200);
                renderBarChartCampaignsHorizontal(data);
            })
            .catch(err => {
                grid.innerHTML = `<div class="col-span-full text-center text-red-500 font-semibold py-8">Gagal memuat data campaign.</div>`;
                renderBarChartCampaignsHorizontal([]);
            });
    }
    // Expand/Collapse Campaigns
    function setupCampaignExpand() {
        const btn = document.querySelector('.expand-btn');
        const grid = document.getElementById('campaigns-grid');
        btn.addEventListener('click', function() {
            let data = [];
            try { data = JSON.parse(grid.dataset.full); } catch { data = []; }
            if (grid.getAttribute("data-state") === "max3") {
                grid.innerHTML = data.map(renderCampaignCard).join('');
                grid.setAttribute("data-state", "all");
                btn.querySelector('span:first-child').textContent = 'Sembunyikan Campaign';
                btn.querySelector('span:last-child').textContent = '⬆';
                setTimeout(animateAllCircleBars, 200);
            } else {
                grid.innerHTML = data.slice(0, 3).map(renderCampaignCard).join('');
                grid.setAttribute("data-state", "max3");
                btn.querySelector('span:first-child').textContent = 'Lihat Semua Campaign';
                btn.querySelector('span:last-child').textContent = '⬇';
                setTimeout(animateAllCircleBars, 200);
            }
        });
    }
    // -- DONATION SECTION --
    function renderDonationItem(d) {
        let badgeClass = "status-badge";
        let badgeText = "Berhasil";
        let st = (d.status || '').toLowerCase();
        if (st !== 'paid') {
            const now = new Date();
            let expired = false;
            if (d.expiry_date) {
                let exp = new Date(d.expiry_date.replace(/-/g,'/'));
                expired = now > exp;
            }
            if (expired) {
                badgeClass += " failed";
                badgeText = "Gagal";
            } else {
                badgeClass += " notpaid";
                badgeText = "Belum Bayar";
            }
        }
        return `<div class="donation-item">
            <div class="donor-info">
                <div class="donor-name">${d.name || '-'}</div>
                <div class="donor-amount">${formatRupiah(d.amount)}</div>
                <div class="donation-time">${d.created_at ? formatWaktu(d.created_at) : '-'}</div>
            </div>
            <div class="payment-method">${d.payment_method || '-'}</div>
            <div class="campaign-tag">${d.campaign_name || '-'}</div>
            <div class="${badgeClass}">${badgeText}</div>
        </div>`;
    }
    function formatWaktu(str) {
        const t = new Date(str.replace(/-/g,'/'));
        const now = new Date();
        const diffMs = now - t;
        const diffMin = Math.floor(diffMs/60000);
        if(diffMin < 1) return 'Baru saja';
        if(diffMin < 60) return `${diffMin} menit yang lalu`;
        const diffJam = Math.floor(diffMin/60);
        if(diffJam < 24) return `${diffJam} jam yang lalu`;
        const diffHari = Math.floor(diffJam/24);
        return `${diffHari} hari yang lalu`;
    }
    function fetchDonations(limit=5) {
        const list = document.getElementById('donations-list');
        list.innerHTML = Array.from({length: limit}).map(()=>`<div class="donation-item loading-skeleton" style="height: 80px"></div>`).join('');
        fetch(`https://rumahamal.usk.ac.id/api-staging/wp-json/custom/v1/transaction?limit=${limit}`)
            .then(res => res.json())
            .then(data => {
                if (!Array.isArray(data) || !data.length) {
                    list.innerHTML = `<div class="col-span-full text-center text-gray-500 font-semibold py-8">Belum ada donasi masuk.</div>`;
                    return;
                }
                list.innerHTML = data.map(renderDonationItem).join('');
            })
            .catch(err => {
                list.innerHTML = `<div class="col-span-full text-center text-red-500 font-semibold py-8">Gagal memuat data donasi.</div>`;
            });
    }
    function setupDonationLimit() {
        const btn5 = document.getElementById('limit5');
        const btn10 = document.getElementById('limit10');
        btn5.classList.add('active');
        btn5.addEventListener('click', function() {
            btn5.classList.add('active'); btn10.classList.remove('active');
            fetchDonations(5);
        });
        btn10.addEventListener('click', function() {
            btn10.classList.add('active'); btn5.classList.remove('active');
            fetchDonations(10);
        });
    }
    document.addEventListener('DOMContentLoaded', function() {
        fetchCampaigns();
        fetchDonations(5);
        setupDonationLimit();
        setTimeout(setupCampaignExpand, 800);
    });
    </script>

        <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            padding: 24px;
            color: #1e293b;
            line-height: 1.6;
            min-height: 100vh;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            padding: 32px 40px;
            border-bottom: 1px solid #e2e8f0;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .header p {
            color: #64748b;
            font-size: 16px;
        }

        .section {
            padding: 40px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 32px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title::before {
            content: '';
            width: 4px;
            height: 24px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border-radius: 2px;
        }

        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, #e2e8f0 0%, transparent 100%);
        }

        /* Campaign Section */
        .campaigns-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 32px;
            margin-bottom: 40px;
        }

        .campaign-card {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border: 1px solid #f1f5f9;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .campaign-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #1d4ed8);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .campaign-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-color: #e2e8f0;
        }

        .campaign-card:hover::before {
            transform: scaleX(1);
        }

        .progress-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 24px;
        }

        .progress-circle {
            position: relative;
            width: 140px;
            height: 140px;
            margin-bottom: 16px;
        }

        .progress-circle svg {
            width: 140px;
            height: 140px;
            transform: rotate(-90deg);
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        .progress-circle .bg-circle {
            fill: none;
            stroke: #f1f5f9;
            stroke-width: 8;
        }

        .progress-circle .progress-arc {
            fill: none;
            stroke: url(#gradient);
            stroke-width: 8;
            stroke-linecap: round;
            transition: stroke-dasharray 1.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 32px;
            font-weight: 800;
            color: #0f172a;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .campaign-name {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            text-align: center;
            margin-bottom: 12px;
        }

        .campaign-stats {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            padding-top: 16px;
            border-top: 1px solid #f1f5f9;
            font-size: 14px;
            color: #64748b;
        }

        .expand-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 16px;
        }

        .expand-btn {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: #475569;
            border: 1px solid #e2e8f0;
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .expand-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
            transition: left 0.5s ease;
        }

        .expand-btn:hover {
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .expand-btn:hover::before {
            left: 100%;
        }

        .expand-btn:active {
            transform: translateY(0);
        }

        /* Current Donation Section */
        .donations-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .donation-item {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border: 1px solid #f1f5f9;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: grid;
            grid-template-columns: 1fr auto auto auto;
            gap: 24px;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .donation-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(135deg, #10b981, #059669);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .donation-item:hover {
            transform: translateX(4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-color: #e2e8f0;
        }

        .donation-item:hover::before {
            transform: scaleY(1);
        }

        .donor-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .donor-name {
            font-size: 16px;
            font-weight: 600;
            color: #0f172a;
        }

        .donor-amount {
            font-size: 14px;
            color: #10b981;
            font-weight: 600;
        }

        .donation-time {
            font-size: 12px;
            color: #64748b;
        }

        .payment-method {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            color: #1d4ed8;
            padding: 8px 16px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            border: 1px solid #bfdbfe;
            min-width: 100px;
        }

        .campaign-tag {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            color: #0369a1;
            padding: 8px 16px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 500;
            border: 1px solid #bae6fd;
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .status-badge {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            color: #166534;
            padding: 8px 16px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            border: 1px solid #bbf7d0;
            min-width: 80px;
            position: relative;
        }

        .status-badge::before {
            content: '●';
            color: #16a34a;
            margin-right: 6px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Loading animation */
        .loading-skeleton {
            background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .campaigns-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 24px;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 16px;
            }

            .container {
                border-radius: 16px;
            }

            .section {
                padding: 24px;
            }

            .header {
                padding: 24px;
            }

            .campaigns-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .donation-item {
                grid-template-columns: 1fr;
                gap: 16px;
                text-align: center;
            }

            .campaign-tag {
                max-width: none;
            }
        }

        @media (max-width: 480px) {
            .progress-circle {
                width: 120px;
                height: 120px;
            }

            .progress-circle svg {
                width: 120px;
                height: 120px;
            }

            .progress-text {
                font-size: 28px;
            }
        }
    </style>
</x-app-layout>