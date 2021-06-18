<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ADMIN BUKU</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>


    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <a class="navbar-brand" href="<?= base_url() . 'admin' ?>">Admin Aplikasi Pustaka</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample03">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="<?= base_url() . 'admin' ?>">Home <span class="sr-only">(current)</span></a>
                </li>
            </ul>


            <form action="<?= base_url() . 'admin/logout' ?>" method="post">
                <button type="submit" name="" id="" class="btn btn-danger">Logout</button>
            </form>

        </div>
    </nav>

    <div class="container mt-5 p-4">

        <script>
            $(".alert").alert();
        </script>
        <?php if ($this->session->flashdata('success')) { ?>

            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong> <?= $this->session->flashdata('success') ?></strong>
            </div>

        <?php } ?>
        <?php if ($this->session->flashdata('error')) { ?>

            <div class="alert alert-error alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong> <?= $this->session->flashdata('error') ?></strong>
            </div>

        <?php } ?>

        <div id="accordianId" role="tablist" aria-multiselectable="true">
            <div class="card">
                <div class="card-header" role="tab" id="section1HeaderId">
                    <h5 class="mb-0">
                        <a data-toggle="collapse" data-parent="#accordianId" href="#section1ContentId" aria-expanded="true" aria-controls="section1ContentId">
                            Tambah Buku Baru
                        </a>
                    </h5>
                </div>
                <div id="section1ContentId" class="collapse in" role="tabpanel" aria-labelledby="section1HeaderId">
                    <div class="card-body">
                        <div class="container">
                            <form action="<?= base_url() . '/api/buku' ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="is_admin" value="1">
                                <div class="form-group">
                                    <label for="">Judul Buku</label>
                                    <input type="text" class="form-control" name="judul" id="" placeholder="Masukkan Judul Buku" required>
                                    <small class="form-text text-muted">Judul Buku</small>
                                </div>
                                <div class="form-group">
                                    <label for="">Penulis Buku</label>
                                    <input type="text" class="form-control" name="penulis" id="" placeholder="Masukkan Penulis Buku" required>
                                    <small class="form-text text-muted">Penulis Buku</small>
                                </div>

                                <div class="form-group">
                                    <label for="">Deskripsi Buku</label>
                                    <textarea class="form-control" placeholder="Deskripsi/Sinopsis Singkat Buku" name="deskripsi" id="" rows="3"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="">Kategori Buku</label>
                                    <select class="form-control" name="kategori" required id="">
                                        <option value="Romansa">Romansa</option>
                                        <option value="Pengetahuan">Pengetahuan</option>
                                        <option value="Sosial">Sosial</option>
                                        <option value="Politik">Politik</option>
                                        <option value="Hukum">Hukum</option>
                                        <option value="Sejarah">Sejarah</option>
                                        <option value="Budaya">Budaya</option>
                                        <option value="Fiksi Ilmiah">Fiksi Ilmiah</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">File Buku (PDF)</label>
                                    <input type="file" required class="form-control-file" accept="application/pdf" name="buku" id="" placeholder="" aria-describedby="fileHelpId">
                                    <small id="fileHelpId" class="form-text text-muted">File PDF Buku</small>
                                </div>
                                <div class="form-group">
                                    <label for="">File Gambar Buku</label>
                                    <input type="file" required class="form-control-file" name="poster" accept="application/jpeg,application/png/,application/jpg" placeholder="" aria-describedby="fileHelpId">
                                    <small id="fileHelpId" class="form-text text-muted">File Gambar Buku</small>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan Buku</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <h2 class="mt-4">Daftar Buku </h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Judul Buku</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Penulis</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">File Buku</th>
                        <th scope="col">Sampul Buku</th>
                        <th scope="col">Edit Buku</th>
                        <th scope="col">Hapus Buku</th>
                    </tr>

                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    foreach ($var_data as $item) {
                        echo "
                    <tr>
                        
                        <th scope='row'>$count</th>
                        <td>$item->judul</td>
                        <td>$item->penulis</td>
                        <td>$item->kategori</td>
                        <td>$item->deskripsi</td>
                        <td>
                            <a href='" . base_url() . '/' . $item->path_buku . "' target='_blank' > <button type='button' class='btn btn-primary'>Lihat Buku</button></a>
                        </td>
                        <td>
                            <img src='" . base_url() . '/' . $item->path_sampul . "' width='200px' height='300px' style='border-radius:20px'>
                        </td>
                        <td>
                            <a href='" . base_url() . 'admin/edit_buku/' . $item->id . "'>
                                <button type='button' class='btn btn-warning'>Edit Buku</button>
                            </a>
                        </td>
                        <td>
                            <form action='" . base_url() . 'api/buku/hapusbuku' . "' method='post'>
                            <input type='hidden' value='$item->id' name='id'>  
                            <input type='hidden' name='is_admin' value='1'>
                                <button type='submit' class='btn btn-danger'>Hapus Buku</button>
                            </form>
                        </td>
                        
                    </tr>
                    ";
                        $count++;
                    }
                    ?>


                </tbody>
            </table>
        </div>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>