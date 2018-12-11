<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<style>
    .center {
        text-align: center;
    }

    .bold {
        font-weight: bold;
    }

    .color-table {
        border-collapse: collapse;
    }

    .color-table, .color-table th, .color-table td {
        border: 2px solid #000000;
    }
</style>
<table class="color-table">

    <thead>
    <tr class="center">
        <th style="text-align: center">Phòng Máy</th>
        <th style="text-align: center">Tên Giảng Viên</th>
        <th style="text-align: center">Mô Tả Giảng Viên</th>
        <th style="text-align: center">Tên Kỷ Thuật Viên</th>
        <th style="text-align: center">Mô tả Kỷ Thuật Viên</th>
        <th style="text-align: center">Ngày Ghi Nhận</th>
        <th style="text-align: center">Ngày Sửa</th>
        <th style="text-align: center">Tình Trạng</th>
        <th style="text-align: center" colspan="2">Chữ Ký</th>
    </tr>
    </thead>

    <tbody>
    <?php $no = 0; ?>
    @foreach($list as $item)
        <?php //dd($item); ?>
        <?php
        $dataPlant['phongMay'] = (!empty($item->phongMay->name)) ? $item->phongMay->name : "-";
        $dataPlant['tenGiangVien'] = (isset($item->giangVien->profile)) ? $item->giangVien->profile->first_name . ' ' . $item->giangVien->profile->last_name : "-";
        $dataPlant['moTaGiangVien'] = (isset($item->mota_gv)) ? $item->mota_gv : "-";
        $dataPlant['tenKyThuatVien'] = (isset($item->kyThuatVien->profile)) ?  $item->kyThuatVien->profile->first_name . ' ' . $item->kyThuatVien->profile->last_name : "-";
        $dataPlant['moTaKyThuatVien'] = (isset($item->mota_ktv)) ? $item->mota_ktv : "-";
        $dataPlant['ngayGhiNhan'] = (isset($item->created_at)) ? $item->created_at : "-";
        $dataPlant['ngaySua'] = (isset($item->updated_at) ? $item->updated_at : "-");
        $dataPlant['tinhTrang'] = (isset($item->status)) ? $item->status : "-";
        ?>
        <tr>
            <td style="text-align: center">{{$dataPlant['phongMay']}}</td>
            <td style="text-align: center">{{$dataPlant['tenGiangVien']}}</td>
            <td style="text-align: center">{{$dataPlant['moTaGiangVien']}}</td>
            <td style="text-align: center">{{$dataPlant['tenKyThuatVien']}}</td>
            <td style="text-align: center">{{$dataPlant['moTaKyThuatVien']}}</td>
            <td style="text-align: center">{{$dataPlant['ngayGhiNhan']}}</td>
            <td style="text-align: center">{{$dataPlant['ngaySua']}}</td>
            <td style="text-align: center">{{$dataPlant['tinhTrang']}}</td>
            <td style="text-align: center" colspan="2"></td>
        </tr>
    @endforeach
    </tbody>

</table>
</body>
</html>
