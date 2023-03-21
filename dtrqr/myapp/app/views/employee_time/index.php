<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Scan QR or Search ID to Log Time</h3>
                <span>&emsp;&emsp;Current Date: <?= date('F d, Y') ?> | Current Time: <span id="t"></span></span>
            </div>
            <div class="box-body">
                <?= form_open('employee_time') ?>
                <div class="form-group" align="center">
                    <label class="radio-inline"><input value="in" type="radio" name="optradio" checked>TIME IN</label>
                    <label class="radio-inline"><input value="out" type="radio" name="optradio">TIME OUT</label>
                </div>
                <div class="form-group">
                    <input name="id_number" type="number" class="form-control text-center input-lg input-block" min=0 max="9999999" required placeholder="ID Number" autofocus="">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-7">
                            <object data="<?= null!==$employee ? base_url('assets/media/qrcode/'.$employee->id.'.png') : base_url('resources/img/qr.png') ?>" width="100%" type="image/png">
                                <img src="<?= base_url('resources/img/qr.png') ?>" alt="QR Image" width="100%">
                            </object>                            
                        </div>
                        <div class="col-md-5">
                            <label>First Name: </label><h4>&emsp;<?= null!==$employee ? $employee->first_name : '-' ?></h4>
                            <label>Last Name: </label><h4>&emsp;<?= null!==$employee ? $employee->last_name : '-' ?></h4>
                            <label>Date Added: </label><h4>&emsp;<?= null!==$employee_time ? $employee_time->date_added : '-' ?></h4>
                            <label>Time In: </label><h4>&emsp;<?= null!==$employee_time ? $employee_time->time_in : '-' ?></h4>
                            <label>Time Out: </label><h4>&emsp;<?= null!==$employee_time ? $employee_time->time_out : '-' ?></h4>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <h3 class="text-success"><?= null!==$msg ? $msg : '' ?></h3>
                </div>
                <?= form_close() ?>
                <div class="form-group">
                    <a href="<?= site_url('employee_time/dtr') ?>" class="btn btn-lg btn-block btn-success">Daily Time Record <i class="fa fa-arrow-right"></i></a>
                </div>       
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    function startTime() {
        const today = new Date();
        let h = today.getHours();
        let m = today.getMinutes();
        let s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('t').innerHTML =  h + ":" + m + ":" + s;
        setTimeout(startTime, 1000);
    }

    function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
    }

    startTime();
</script>
