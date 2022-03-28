<?php
class Database
{
  protected $stmt;
  protected $db;

  public function __construct()
  {
    $conn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
    try {
      $this->db = new PDO($conn, DB_USER, DB_PASS, [
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      ]);
    } catch (PDOException $e) {
      $error = 404;
      require_once BASEURL . "pages/error.php";
    }
  }

  public function query(String $query): object
  {
    $this->stmt = $this->db->prepare($query);
    return $this;
  }

  public function bind(String $param, String $value, String $type = null): object
  {
    switch ($type == null) {
      case is_int($value):
        $type = PDO::PARAM_INT;
        break;
      case is_null($value):
        $type = PDO::PARAM_BOOL;
        break;
      case is_bool($value):
        $type = PDO::PARAM_BOOL;
        break;
      default:
        $type = PDO::PARAM_STR;
    }

    $this->stmt->bindValue($param, $value, $type);
    return $this;
  }

  public function resultSet(): array
  {
    $this->stmt->execute();
    return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function rowCount(): int
  {
    $this->stmt->execute();
    return $this->stmt->rowCount();
  }

  public function sanitizeHtml(array $sanitize): array
  {
    $cleanData = [];
    foreach ($sanitize as $key => $value) {
      $cleanData[$key] = $value;
    }
    return $cleanData;
  }

  /* CRUD */
  public function insert($table, $data): int
  {
    $query = "INSERT INTO $table VALUES (";
    $dataLength = count($data);
    $cleanData = $this->sanitizeHtml($data);

    for ($i = 0; $i < $dataLength - 1; $i++) {
      $query .= "?,";
    }
    $query .= "?)";
    $this->query($query);

    $indexBind = 1;
    foreach ($cleanData as $key => $value) {
      $this->bind($indexBind, $value);
    }

    return $this->rowCount();
  }

  public function select(String $table, array $by = null): array
  {
    $query = "SELECT * FROM $table ";
    if ($by == null) $query .= "WHERE {$by['by']} = :by";

    $this->query($query);
    if ($by == null) $this->bind('by', $by['value']);
    return $this->resultSet();
  }

  public function delete(String $table, array $by = null): int
  {
    $query = "DELETE FROM $table ";
    if ($by == null) $query .= "WHERE {$by['by']} = :by";

    $this->query($query);
    if ($by == null) $this->bind('by', $by['value']);
    return $this->rowCount();
  }

  public function update(String $table, array $data, array $by): int
  {
    $cleanData = [];
    $query = "UPDATE $table SET ";

    $indexCurrent = 1;
    foreach ($data as $key => $value) {
      if (count($data) == $indexCurrent) {
        $cleanData[$key] = $value;
        $query .= $key . "=? ";
        break;
      }
      $cleanData[$key] = $value;
      $query .= $key . "=?,";
      $indexCurrent++;
    }
    $query .= "WHERE {$by['key']} = :by";

    foreach ($cleanData as $key => $value) {
      $this->bind($key, $value);
    }
    $this->bind('by', $by['value']);

    return $this->rowCount();
  }
}
