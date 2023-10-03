<?php

class FakultasRepository extends Model
{
  function getFakultasList(): array
  {
    try {
      return $this->db->fetchAll("SELECT * FROM fakultas");
    } catch (Exception $e) {
      Logger::error(__FILE__, __LINE__, "Failed to fetch `fakultas`: " . $e->getMessage());
      throw $e;
    }
  }

  function getFakultas(string $kode): array
  {
    try {
      return $this->db->fetch("SELECT * FROM fakultas WHERE kode=$1 LIMIT 1", [$kode]);
    } catch (Exception $e) {
      Logger::error(__FILE__, __LINE__, "Failed to fetch `fakultas`: " . $e->getMessage());
      throw $e;
    }
  }

  function insertFakultas(string $kode, string $nama)
  {
    try {
      $query = "INSERT INTO fakultas (kode, nama) VALUES ($1, $2)";
      $this->db->execute($query, [$kode, $nama]);
    } catch (Exception $e) {
      Logger::error(__FILE__, __LINE__, "Failed to insert into `fakultas`: " . $e->getMessage());
      throw $e;
    }
  }

  function updateFakultas(string $kode, string $nama)
  {
    try {
      $query = " UPDATE fakultas SET nama=$1 WHERE kode=$2";
      $this->db->execute($query, [$nama, $kode]);
    } catch (Exception $e) {
      Logger::error(__FILE__, __LINE__, "Failed to update `fakultas`: " . $e->getMessage());
      throw $e;
    }
  }

  function deleteFakultas(string $kode)
  {
    try {
      $query = "DELETE FROM fakultas WHERE kode=$1";
      $this->db->execute($query, [$kode]);
    } catch (Exception $e) {
      Logger::error(__FILE__, __LINE__, "Failed to delete from `fakultas`: " . $e->getMessage());
      throw $e;
    }
  }
}
