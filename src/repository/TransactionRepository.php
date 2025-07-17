

public function countTransactionsByCompteId(int $clientId): int
{
    $query = "SELECT COUNT(*) FROM transactions WHERE user_id = :user_id";
    $stmt = $this->DB->prepare($query);
    $stmt->execute(['user_id' => $clientId]);
    return (int) $stmt->fetchColumn();
}
    public function getTransactionsByCompteId(int $userId, int $limit = null): array
{
    $query = "SELECT * FROM transactions WHERE user_id = :user_id ORDER BY datetransaction DESC";
    if ($limit) {
        $query .= " LIMIT :limit";
    }
    
    $stmt = $this->DB->prepare($query);
    $stmt->bindValue('user_id', $userId);
    
    if ($limit) {
        $stmt->bindValue('limit', $limit );
    }
    
    $stmt->execute();
    return $stmt->fetchAll();
}