<?= $this->session->flashdata('message'); ?>
<section class="section">
    <div class="section-header">
        <h1>Aging Rate</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Aging Rate</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Aging Rate</h4>
                    </div>
                    <div class="card-body">
                    <div class="row justify-content-beetwen">
                        <div class="col-md-3">
                            <detail>
                                <span>Total Lancar tdk Bermasalah</span> <br>
                                <span>Total Kurang Lancar tdk Bermasalah</span> <br>
                                <span>Total Diragukan tdk Bermasalah</span> <br>
                                <span>Total Macet tdk Bermasalah</span> <br>
                                <span>Selisih</span> <br>
                                <span>Total</span> <br>
                                <br>
                                <span>Total Alokasi industri</span> <br>
                                <span>Total Alokasi perdagangan</span> <br>
                                <span>Total Alokasi pertanian</span> <br>
                                <span>Total Alokasi perkebunan</span> <br>
                                <span>Total Alokasi perikanan</span> <br>
                                <span>Total Alokasi peternakan</span> <br>
                                <span>Total Alokasi jasa</span> <br>
                                <span>Total Alokasi lainlain</span> <br>
                            </detail>
                        </div>
                        <div class="col-md-3">
                            <detail>
                                <span class="pr-3">:</span><?= number_format($totLancartdkbermasalah) ?><br>
                                <span class="pr-3">:</span><?= number_format($totKurangLancartdkbermasalah) ?><br>
                                <br>
                                <span class="pr-3">:</span><?= number_format($totDiragukantdkbermasalah) ?><br>
                                <span class="pr-3">:</span><?= number_format($totMacettdkbermasalah) ?><br>
                                <span class="pr-3">:</span><?= number_format($selisih) ?><br>
                                <span class="pr-3">:</span><?= number_format($totalMB) ?><br>
                                <br>
                                <span class="pr-3">:</span><?= number_format($totalokindustri) ?><br>
                                <span class="pr-3">:</span><?= number_format($totalokperdagangan) ?><br>
                                <span class="pr-3">:</span><?= number_format($totalokpertanian) ?><br>
                                <span class="pr-3">:</span><?= number_format($totalokperkebunan) ?><br>
                                <span class="pr-3">:</span><?= number_format($totalokperikanan) ?><br>
                                <span class="pr-3">:</span><?= number_format($totalokpeternakan) ?><br>
                                <span class="pr-3">:</span><?= number_format($totalokjasa) ?><br>
                                <span class="pr-3">:</span><?= number_format($totaloklainlain) ?><br>

                            </detail>
                        </div>
                        <div class="col-md-3">
                            <detail>
                                <span>Probability Default lancar</span> <br>
                                <span>Probability Default kuranglancar</span> <br>
                                <span>Probability Default diragukan</span> <br>
                                <span>Probability Default macet</span> <br>
                                <br>
                                <span>Tarip Penyisihan lancar</span> <br>
                                <span>Tarip Penyisihan kuranglancar</span> <br>
                                <span>Tarip Penyisihan diragukan</span> <br>
                                <span>Tarip Penyisihan macet</span> <br>
                                <br>
                                <span>Alokasi lancar</span> <br>
                                <span>Alokasi kuranglancar</span> <br>
                                <span>Alokasi diragukan</span> <br>
                                <span>Alokasi macet</span> <br>
                            </detail>
                        </div>
                        <div class="col-md-3">
                            <detail>
                                <span class="pr-3">:</span><?= round($pdlancar, 2) ?><br>
                                <span class="pr-3">:</span><?= round($pdkuranglancar, 2) ?><br>
                                <span class="pr-3">:</span><?= round($pddiragukan, 6) ?><br>
                                <span class="pr-3">:</span><?= round($pdmacet, 2) ?><br>
                                <br>
                                <span class="pr-3">:</span><?= $tplancar ?><br>
                                <span class="pr-3">:</span><?= $tpkuranglancar ?><br>
                                <span class="pr-3">:</span><?= $tpdiragukan ?><br>
                                <span class="pr-3">:</span><?= $tpmacet ?><br>
                                <br>
                                <span class="pr-3">:</span><?= number_format($aloklancar) ?><br>
                                <span class="pr-3">:</span><?= number_format($alokkuranglancar) ?><br>
                                <span class="pr-3">:</span><?= number_format($alokdiragukan) ?><br>
                                <span class="pr-3">:</span><?= number_format($alokmacet) ?><br>
                            </detail>
                        </div>
                    </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>
