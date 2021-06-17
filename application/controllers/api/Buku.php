<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Buku extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->library('form_validation');
        $this->load->database();
    }

    //Menampilkan data kontak
    function index_get()
    {
        $id = $this->get('id');
        if ($id == '') {
            $data = $this->db->get('buku')->result();
        } else {
            $this->db->where('id', $id);
            $data = $this->db->get('buku')->result();
        }

        $returndata = array('status' => 1, 'count' => count($data), 'data' => $data, 'message' => 'success fetch_data');
        $this->set_response($returndata, 200);
    }

    function index_delete()
    {
        $this->load->helper('url');
        $id = $this->delete('id');
        $this->db->where('id', $id);
        $data = $this->db->get('buku')->result();

        if (count($data) > 0) {
            try {
                $pathPoster = $data[0]->path_sampul;
                $pathBuku = $data[0]->path_buku;
                unlink($pathBuku);
                unlink($pathPoster);
            } catch (Exception $e) {
            }

            $this->db->where('id', $id);
            $delete = $this->db->delete('buku');
            if ($delete) {
                $returndata = array('status' => 1, 'message' => 'buku berhasil dihapus');
                $this->set_response($returndata, 200);
            } else {
                $returndata = array('status' => 0, 'message' => 'buku gagal dihapus');
                $this->set_response($returndata, 500);
            }
        } else {
            $returndata = array('status' => 0, 'message' => 'id buku tidak ditemukan');
            $this->set_response($returndata, 400);
        }
    }

    public function index_post()
    {
        $configPoster = array(
            'upload_path' => 'uploads/',            //path for upload
            'allowed_types' => "gif|jpg|png|jpeg",   //restrict extension
            'file_name' => 'logo_' . date('ymdhis')
        );


        $this->load->library('upload', $configPoster);

        $pathPoster = "";
        $pathBuku = "";

        if ($this->upload->do_upload('poster')) {
            $data = array('upload_data' => $this->upload->data());
            $pathPoster = $configPoster['upload_path'] . '' . $data['upload_data']['orig_name'];
        }

        $configBuku = array(
            'upload_path' => 'uploads/',            //path for upload
            'allowed_types' => "pdf",   //restrict extension
            'file_name' => 'book_' . date('ymdhis')
        );
        $this->upload->initialize($configBuku);

        if ($this->upload->do_upload('buku')) {
            $data = array('upload_data' => $this->upload->data());
            $pathBuku = $configBuku['upload_path'] . '' . $data['upload_data']['orig_name'];
        }

        $book = array(
            'judul'    => $this->post('judul'),
            'penulis'    => $this->post('penulis'),
            'kategori'    => $this->post('kategori'),
            'deskripsi'    => $this->post('deskripsi'),
            'path_sampul'    => $pathPoster,
            'path_buku'    => $pathBuku,
        );

        $insert = $this->db->insert('buku', $book);
        $returndata = array('status' => 1, 'data' => 'user details', 'book' => $book, 'message' => 'image uploaded successfully');
        $this->set_response($returndata, 200);
    }


    public function updatebuku_post()
    {

        $id = $this->post('id');
        $this->db->where('id', $this->post('id'));
        $data = $this->db->get('buku')->result();
        $this->set_response($data, 422);

        if (count($data) == 0) {
            $returndata = array('status' => 0, 'message' => 'id buku tidak ditemukan');
            $this->set_response($returndata, 422);
        } else {

            $isBukuExists = isset($_FILES['buku']) && $_FILES['buku']['name'][0] != "";
            $isPosterExists = isset($_FILES['poster']) && $_FILES['poster']['name'][0] != "";


            if ($isPosterExists && !$isBukuExists) {
                $this->db->where('id', $id);
                $data = $this->db->get('buku')->result();

                $pathBuku="";
                try {
                    $pathPoster = $data[0]->path_sampul;
                    $pathBuku = $data[0]->path_buku;
                    unlink($pathPoster);
                } catch (Exception $e) {
                }

                $configPoster = array(
                    'upload_path' => 'uploads/',
                    'allowed_types' => "gif|jpg|png|jpeg",
                    'file_name' => 'logo_' . date('ymdhis')
                );

                $this->load->library('upload', $configPoster);

                $pathPoster = "";

                if ($this->upload->do_upload('poster')) {
                    $data = array('upload_data' => $this->upload->data());
                    $pathPoster = $configPoster['upload_path'] . '' . $data['upload_data']['orig_name'];
                }

                $book = array(
                    'judul'    => $this->post('judul'),
                    'penulis'    => $this->post('penulis'),
                    'kategori'    => $this->post('kategori'),
                    'deskripsi'    => $this->post('deskripsi'),
                    'path_sampul'    => $pathPoster,
                    'path_buku'    => $pathBuku,
                );

                $id = $this->post('id');
                $this->db->where('id', $id);
                $insert = $this->db->update('buku', $book);
                $returndata = array('status' => 1, 'message' => 'berhasil mengupdate buku with only poster', 'book' => $book);
                $this->set_response($returndata, 200);

            } else if ($isBukuExists && !$isPosterExists) {
                // If Only Buku is Replaced, but poster is not replaced
                $this->db->where('id', $id);
                $data = $this->db->get('buku')->result();

                try {
                    $pathPoster = $data[0]->path_sampul;
                    $pathBuku = $data[0]->path_buku;
                    unlink($pathBuku);
                } catch (Exception $e) {
                }


                $configBuku = array(
                    'upload_path' => 'uploads/',            //path for upload
                    'allowed_types' => "pdf",   //restrict extension
                    'file_name' => 'book_' . date('ymdhis')
                );

                $this->load->library('upload', $configBuku);

                $pathBuku = "";

                if ($this->upload->do_upload('buku')) {
                    $data = array('upload_data' => $this->upload->data());
                    $pathBuku = $configBuku['upload_path'] . '' . $data['upload_data']['orig_name'];
                }

                $book = array(
                    'judul'    => $this->post('judul'),
                    'penulis'    => $this->post('penulis'),
                    'kategori'    => $this->post('kategori'),
                    'deskripsi'    => $this->post('deskripsi'),
                    'path_buku'    => $pathBuku,
                );

                $id = $this->post('id');
                $this->db->where('id', $id);
                $insert = $this->db->update('buku', $book);
                $returndata = array('status' => 1, 'message' => 'berhasil mengupdate buku with only buku', 'book' => $book,);
                $this->set_response($returndata, 200);
                
            } else if ($isPosterExists && $isBukuExists) {
                // If Both Poster and Buku is Replaced
                $this->db->where('id', $id);
                $data = $this->db->get('buku')->result();

                $pathPoster = "";
                $pathBuku = "";


                try {
                    $pathPoster = $data[0]->path_sampul;
                    $pathBuku = $data[0]->path_buku;
                    unlink($pathBuku);
                    unlink($pathPoster);
                } catch (Exception $e) {

                }

                $configPoster = array(
                    'upload_path' => 'uploads/',            //path for upload
                    'allowed_types' => "gif|jpg|png|jpeg",   //restrict extension
                    'max_size' => '100',
                    'max_width' => '1024',
                    'max_height' => '768',
                    'file_name' => 'logo_' . date('ymdhis')
                );

                $this->load->library('upload', $configPoster);

           
                if ($this->upload->do_upload('poster')) {
                    $data = array('upload_data' => $this->upload->data());
                    $pathPoster = $configPoster['upload_path'] . '' . $data['upload_data']['orig_name'];
                }

                $configBuku = array(
                    'upload_path' => 'uploads/',            //path for upload
                    'allowed_types' => "pdf",   //restrict extension
                    'file_name' => 'book_' . date('ymdhis')
                );
                $this->upload->initialize($configBuku);

                if ($this->upload->do_upload('buku')) {
                    $data = array('upload_data' => $this->upload->data());
                    $pathBuku = $configBuku['upload_path'] . '' . $data['upload_data']['orig_name'];
                }

                $book = array(
                    'judul'    => $this->post('judul'),
                    'penulis'    => $this->post('penulis'),
                    'kategori'    => $this->post('kategori'),
                    'deskripsi'    => $this->post('deskripsi'),
                    'path_sampul'    => $pathPoster,
                    'path_buku'    => $pathBuku,
                );

                $id = $this->post('id');
                $this->db->where('id', $id);
                $insert = $this->db->update('buku', $book);
                if ($insert) {
                    $returndata = array('status' => 1, 'message' => 'berhasil mengupdate buku with both', 'book' => $book,);
                    $this->set_response($returndata, 200);
                } else {
                    $returndata = array('status' => 0, 'message' => 'gagal mengupdate buku with both', 'book' => $book,);
                    $this->set_response($returndata, 422);
                }
            } else {
                $book = array(
                    'judul'    => $this->post('judul'),
                    'penulis'    => $this->post('penulis'),
                    'kategori'    => $this->post('kategori'),
                    'deskripsi'    => $this->post('deskripsi'),
                );

                $id = $this->post('id');
                $this->db->where('id', $id);
                $insert = $this->db->update('buku', $book);
                if ($insert) {
                    $returndata = array('status' => 1, 'message' => 'berhasil mengupdate buku data', 'book' => $book,);
                    $this->set_response($returndata, 200);
                } else {
                    $returndata = array('status' => 0, 'message' => 'gagal mengupdate buku with data', 'book' => $book,);
                    $this->set_response($returndata, 422);
                }
            }
        }
    }
}
