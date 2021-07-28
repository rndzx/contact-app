<?php
        //Koneksi Database
        $server = "localhost";
        $user = "root";
        $pass = "";
        $database = "nomor_wa";

        $koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));
        
        //jika tombol simpan diklik
	if(isset($_POST['bsimpan']))
	{
		//Pengujian Apakah data akan diedit atau disimpan baru
		if($_GET['hal'] == "edit")
		{
			//Data akan di edit
			$edit = mysqli_query($koneksi, "UPDATE tmhs set
											 	nama = '$_POST[tnama]',
											 	nomor = '$_POST[tnomor]',
												deks = '$_POST[tdeks]',
											 	jekel = '$_POST[tjekel]'
											 WHERE id_mhs = '$_GET[id]'
										   ");
			if($edit) //jika edit sukses
			{
				echo "<script>
						alert('Edit Kontak Berhasil!');
						document.location='index.php';
				     </script>";
			}
			else
			{
				echo "<script>
						alert('Edit Kontak Gagal!!');
						document.location='index.php';
				     </script>";
			}
		}
		else
		{
			//Data akan disimpan Baru
			$simpan = mysqli_query($koneksi, "INSERT INTO tmhs (nama, nomor, deks, jekel)
										  VALUES ('$_POST[tnama]', 
										  		 '$_POST[tnomor]', 
										  		 '$_POST[tdeks]', 
										  		 '$_POST[tjekel]')
										 ");
			if($simpan) //jika simpan sukses
			{
				echo "<script>
						alert('Simpan Kontak Berhasil!');
						document.location='index.php';
				     </script>";
			}
			else
			{
				echo "<script>
						alert('Simpan Kontak Gagal!!');
						document.location='index.php';
				     </script>";
			}
		}


		
	}


	//Pengujian jika tombol Edit / Hapus di klik
	if(isset($_GET['hal']))
	{
		//Pengujian jika edit Data
		if($_GET['hal'] == "edit")
		{
			//Tampilkan Data yang akan diedit
			$tampil = mysqli_query($koneksi, "SELECT * FROM tmhs WHERE id_mhs = '$_GET[id]' ");
			$data = mysqli_fetch_array($tampil);
			if($data)
			{
				//Jika data ditemukan, maka data ditampung ke dalam variabel
				$vnama = $data['nama'];
				$vnomor = $data['nomor'];
				$vdeks = $data['deks'];
				$vjekel = $data['jekel'];
			}
		}
		else if ($_GET['hal'] == "hapus")
		{
			//Persiapan hapus data
			$hapus = mysqli_query($koneksi, "DELETE FROM tmhs WHERE id_mhs = '$_GET[id]' ");
			if($hapus){
				echo "<script>
						alert('Hapus Kontak Berhasil!!');
						document.location='index.php';
				     </script>";
			}
		}
        }

?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/bootstrap-icon.min.css"/>
    <title>Contact App - Rndzx</title>
  </head>
    <body>
    <div class="container">
        <h1 class="text-center">CRUD Bootstrap, PHP, & MySQL</h1>
        <h1 class="text-center">Contact App</h1>
    
        <!--Awal Card Form-->
        <div class="card mt-3">
        <div class="card-header bg-primary text-white">
            Form Input Data Daftar Kontak
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Masukkan nama kontak" required></input>
                </div>
                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input type="text" name="tnomor" value="<?=@$vnomor?>" class="form-control" placeholder="Masukkan nomor telepon" required>
                </div>
                <div class="form-group">
                    <label>Deksripsi</label>
                    <textarea name="tdeks" class="form-control" placeholder="Dekripsikan tentang kontak ini"><?=@$vdeks?></textarea>
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select class="form-control" name="tjekel">
                        <option value="<?=@$vjekel?>"><?=@$vjekel?></option>
                        <option value="Laki-Laki">Laki-Laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
                <button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>
            </form>
        </div>
        </div>
        <!--Akhir Card Form-->
        
        <!--Awal Tabel Form-->
        <div class="card mt-3">
        <div class="card-header bg-success text-white">
            Daftar Kontak
        </div>
        <div class="card-body">
           <table class="table table-border table-striped">
               <tr>
                   <th>No</th>
                   <th>Nama</th>
                   <th>No. Tlpn</th>
                   <th>Deksripsi</th>
                   <th>Jenis Kelamin</th>
                   <th>Aksi</th>
               </tr>
               <?php
                    $no = 1;
                    $tampil = mysqli_query($koneksi, " SELECT * from tmhs order by id_mhs desc");
                    while($data = mysqli_fetch_array($tampil)) :

                ?>
               <tr>
                   <td><?=$no++;?></td>
                   <td><?=$data['nama']?></td>
                   <td><?=$data['nomor']?></td>
                   <td><?=$data['deks']?></td>
                   <td><?=$data['jekel']?></td>
                   <td>
                       <a href="index.php?hal=edit&id=<?=$data['id_mhs']?>" class="btn btn-warning"><i class="bi-pencil-square"></i> Edit </a>
                       <a href="index.php?hal=hapus&id=<?=$data['id_mhs']?>" onclick="return confirm('Apakah yakin ingin menghapus kontak ini?')" class="btn btn-danger"> Hapus </a>
                   </td>
               </tr>
               <?php endwhile; //penutup perulangan while ?>
           </table>
        </div>
        </div>
        <!--Akhir Tabel Form-->

    </div>

    <!--footer-->
    <footer class="">
        <div class="container">
            <div class="row text-center pt-3">
                <div class="col">
                    <p>Copyright 2021 . Code by <a href="#" target="_blank">Rianda ID</a></p>
                </div>
            </div>
        </div>
    </footer>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/bootstrap.min.js></script>
  </body>
</html>