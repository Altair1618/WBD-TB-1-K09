<?php

class MataKuliahRepository extends Model
{
  function getMataKuliahList(): array
  {
    try {
      return $this->db->fetchAll("SELECT * FROM mata_kuliah");
    } catch (Exception $e) {
      Logger::error(__FILE__, __LINE__, "Failed to fetch `mata_kuliah`: " . $e->getMessage());
      throw $e;
    }
  }

  function getMataKuliah(string $kode): array|false
  {
    try {
      return $this->db->fetch("SELECT * FROM mata_kuliah WHERE kode=$1 LIMIT 1", [$kode]);
    } catch (Exception $e) {
      Logger::error(__FILE__, __LINE__, "Failed to fetch `mata_kuliah`: " . $e->getMessage());
      return null;
    }
  }

  function getMataKuliahFiltered(string $search = null, string $fakultas = null, string $kode_prodi = null, string $sort_param, string $sort_order, int $page, int $limit): array
  {
    try {
      $offset = ($page - 1) * $limit;

      $query = "
        SELECT mk.kode, mk.nama
        FROM mata_kuliah mk
        JOIN program_studi ps ON mk.kode_program_studi = ps.kode
        JOIN fakultas f ON ps.kode_fakultas = f.kode
        WHERE (mk.kode ILIKE $1 OR mk.nama ILIKE $1)
        AND (ps.kode = $2 OR $2 = '')
        AND (f.kode = $3 OR $3 = '')
        ORDER BY $sort_param $sort_order
        LIMIT $4 OFFSET $5
      ";

      return $this->db->fetchAll($query, ["%$search%", "$kode_prodi", "$fakultas", $limit, $offset]);
    } catch (Exception $e) {
      Logger::error(__FILE__, __LINE__, "Failed to fetch `mata_kuliah`: " . $e->getMessage());
      throw $e;
    }
  }

  function getMataKuliahFilteredCount(string $search = null, string $fakultas = null, string $kode_prodi = null) {
    try {
      $query = "
        SELECT 1
        FROM mata_kuliah mk
        JOIN program_studi ps ON mk.kode_program_studi = ps.kode
        JOIN fakultas f ON ps.kode_fakultas = f.kode
        WHERE (mk.nama ILIKE $1)
        AND (ps.kode = $2 OR $2 = '')
        AND (f.kode = $3 OR $3 = '')
      ";

      return $this->db->rowCount($query, ["%$search%", "$kode_prodi", "$fakultas"]);
    } catch (Exception $e) {
      Logger::error(__FILE__, __LINE__, "Failed to fetch `mata_kuliah`: " . $e->getMessage());
      throw $e;
    }
  }

  function insertMataKuliah(string $kode, string $nama, ?string $deskripsi, ?string $kode_program_studi)
  {
    try {
      $query = "INSERT INTO mata_kuliah (kode, nama, deskripsi, kode_program_studi) VALUES ($1, $2, $3, $4)";
      $this->db->execute($query, [$kode, $nama, $deskripsi, $kode_program_studi]);
    } catch (Exception $e) {
      Logger::error(__FILE__, __LINE__, "Failed to insert into `mata_kuliah`: " . $e->getMessage());
      throw $e;
    }
  }

  function updateMataKuliah(string $kode, string $nama, string $deskripsi, ?string $kode_program_studi)
  {
    try {
      $query = "UPDATE mata_kuliah SET nama=$1, deskripsi=$2, kode_program_studi=$3 WHERE kode=$4";
      $this->db->execute($query, [$nama, $deskripsi, $kode_program_studi, $kode]);
    } catch (Exception $e) {
      Logger::error(__FILE__, __LINE__, "Failed to update `mata_kuliah`: " . $e->getMessage());
      throw $e;
    }
  }

  function deleteMataKuliah(string $kode)
  {
    try {
      $query = "DELETE FROM mata_kuliah WHERE kode=$1";
      $this->db->execute($query, [$kode]);
    } catch (Exception $e) {
      Logger::error(__FILE__, __LINE__, "Failed to delete from `mata_kuliah`: " . $e->getMessage());
      throw $e;
    }
  }
}
