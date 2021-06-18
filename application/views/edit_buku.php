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

        <div class="card">
            <div class="card-header" role="tab" id="section1HeaderId">
                <h5 class="mb-0">
                    <a data-toggle="collapse" data-parent="#accordianId" href="#section1ContentId" aria-expanded="true" aria-controls="section1ContentId">
                        Edit Buku
                    </a>
                </h5>
            </div>
            <div id="section1ContentId" role="tabpanel" aria-labelledby="section1HeaderId">
                <div class="card-body">
                    <div class="container">
                        <form action="<?= base_url() . 'api/buku/updatebuku' ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $var_buku->id ?>">
                            <input type="hidden" name="is_admin" value="1">
                            <div class="form-group">
                                <label for="">Judul Buku</label>
                                <input type="text" class="form-control" name="judul" id="" value="<?= $var_buku->judul ?>" placeholder="Masukkan Judul Buku" required>
                                <small class="form-text text-muted">Judul Buku</small>
                            </div>
                            <div class="form-group">
                                <label for="">Penulis Buku</label>
                                <input type="text" class="form-control" name="penulis" value="<?= $var_buku->penulis ?>" placeholder="Masukkan Penulis Buku" required>
                                <small class="form-text text-muted">Penulis Buku</small>
                            </div>

                            <div class="form-group">
                                <label for="">Deskripsi Buku</label>
                                <textarea class="form-control" placeholder="Deskripsi/Sinopsis Singkat Buku" name="deskripsi" id="" rows="3"><?= $var_buku->deskripsi ?>
                            </textarea>
                            </div>

                            <div class="form-group">
                                <label for="">Kategori Buku</label>
                                <select class="form-control" name="kategori" required id="">
                                    <option value="Romansa" <?= ($var_buku->kategori == "Romansa") ? "selected" : "";  ?>> Romansa</option>
                                    <option value="Pengetahuan" <?= ($var_buku->kategori == "Pengetahuan") ? "selected" : "";  ?>>Pengetahuan</option>
                                    <option value="Sosial" <?= ($var_buku->kategori == "Sosial") ? "selected" : "";  ?>> Sosial</option>
                                    <option value="Politik" <?= ($var_buku->kategori == "Politik") ? "selected" : "";  ?>>Politik</option>
                                    <option value="Hukum" <?= ($var_buku->kategori == "Hukum") ? "selected" : "";  ?>>Hukum</option>
                                    <option value="Sejarah" <?= ($var_buku->kategori == "Sejarah") ? "selected" : "";  ?>>Sejarah</option>
                                    <option value="Budaya" <?= ($var_buku->kategori == "Budaya") ? "selected" : "";  ?>> Budaya</option>
                                    <option value="Fiksi Ilmiah" <?= ($var_buku->kategori == "Fiksi Ilmiah") ? "selected" : "";  ?>> >Fiksi Ilmiah</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>


    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>