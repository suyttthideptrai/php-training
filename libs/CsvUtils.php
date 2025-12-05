<?php

class CsvUtils
{
    private $filepath;
    private $delimiter;
    private $enclosure;

    /**
     * Constructor
     * @param string $filepath Path to CSV file
     * @param string $delimiter CSV delimiter (default: comma)
     * @param string $enclosure CSV enclosure character (default: double quote)
     */
    public function __construct($filepath, $delimiter = ',', $enclosure = '"')
    {
        $this->filepath = $filepath;
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
    }

    /**
     * Read all rows from CSV file
     * @return array Array of all rows (excluding header)
     */
    public function readAll()
    {
        $rows = [];
        if (!file_exists($this->filepath)) {
            return $rows;
        }

        $file = fopen($this->filepath, 'r');
        if ($file === false) {
            return $rows;
        }

        // Skip header
        fgetcsv($file, 0, $this->delimiter, $this->enclosure, '\\');

        while (($row = fgetcsv($file, 0, $this->delimiter, $this->enclosure, '\\')) !== false) {
            $rows[] = $row;
        }
        fclose($file);

        return $rows;
    }

    /**
     * Read header from CSV file
     * @return array Header row
     */
    public function readHeader()
    {
        if (!file_exists($this->filepath)) {
            return [];
        }

        $file = fopen($this->filepath, 'r');
        if ($file === false) {
            return [];
        }

        $header = fgetcsv($file, 0, $this->delimiter, $this->enclosure, '\\');
        fclose($file);

        return $header ?: [];
    }

    /**
     * Read row at specific position (0-based index, excluding header)
     * @param int $index Row index (0-based)
     * @return array|null Row data or null if not found
     */
    public function readRow($index)
    {
        if ($index < 0) {
            return null;
        }

        if (!file_exists($this->filepath)) {
            return null;
        }

        $file = fopen($this->filepath, 'r');
        if ($file === false) {
            return null;
        }

        // Skip header
        fgetcsv($file, 0, $this->delimiter, $this->enclosure, '\\');

        $currentIndex = 0;
        while (($row = fgetcsv($file, 0, $this->delimiter, $this->enclosure, '\\')) !== false) {
            if ($currentIndex === $index) {
                fclose($file);
                return $row;
            }
            $currentIndex++;
        }
        fclose($file);

        return null;
    }

    /**
     * Append a new row to CSV file
     * @param array $row Row data to append
     * @return bool True on success, false on failure
     */
    public function appendRow($row)
    {
        $file = fopen($this->filepath, 'a');
        if ($file === false) {
            return false;
        }

        $result = fputcsv($file, $row, $this->delimiter, $this->enclosure, '\\');
        fclose($file);

        return $result !== false;
    }

    /**
     * Update row at specific position with new data
     * @param int $index Row index (0-based)
     * @param array $row New row data
     * @return bool True on success, false on failure
     */
    public function updateRow($index, $row)
    {
        // If $index is array, treat as query
        if (is_array($index)) {
            return $this->updateRowByQuery($index, $row);
        }

        if ($index < 0 || !file_exists($this->filepath)) {
            return false;
        }

        // Read all rows
        $allRows = $this->readAll();
        $header = $this->readHeader();

        if ($index >= count($allRows)) {
            return false;
        }

        // Update the row
        $allRows[$index] = $row;

        // Write back to file
        return $this->writeAllRows($header, $allRows);
    }

    /**
     * Update rows matching query criteria
     * @param array $query Associative array [header_name => value]
     * @param array $row New row data to update matching rows
     * @return int Number of rows updated
     */
    private function updateRowByQuery($query, $row)
    {
        if (!file_exists($this->filepath)) {
            return 0;
        }

        $header = $this->readHeader();
        $allRows = $this->readAll();
        $updatedCount = 0;

        if (empty($header)) {
            return 0;
        }

        // Find matching rows and update
        foreach ($allRows as $i => $currentRow) {
            if ($this->rowMatchesQuery($currentRow, $header, $query)) {
                $allRows[$i] = $row;
                $updatedCount++;
            }
        }

        if ($updatedCount > 0) {
            $this->writeAllRows($header, $allRows);
        }

        return $updatedCount;
    }

    /**
     * Delete rows matching query criteria
     * @param array $query Associative array [header_name => value]
     * @return int Number of rows deleted
     */
    public function deleteRow($query)
    {
        // If $query is integer, delete by index
        if (is_int($query)) {
            return $this->deleteRowByIndex($query);
        }

        // Delete by query criteria
        if (!is_array($query) || empty($query) || !file_exists($this->filepath)) {
            return 0;
        }

        $header = $this->readHeader();
        $allRows = $this->readAll();

        if (empty($header)) {
            return 0;
        }

        $initialCount = count($allRows);
        $filteredRows = [];

        // Keep only rows that don't match query
        foreach ($allRows as $currentRow) {
            if (!$this->rowMatchesQuery($currentRow, $header, $query)) {
                $filteredRows[] = $currentRow;
            }
        }

        $deletedCount = $initialCount - count($filteredRows);

        if ($deletedCount > 0) {
            $this->writeAllRows($header, $filteredRows);
        }

        return $deletedCount;
    }

    /**
     * Delete row at specific index
     * @param int $index Row index (0-based)
     * @return bool True on success, false on failure
     */
    private function deleteRowByIndex($index)
    {
        if ($index < 0 || !file_exists($this->filepath)) {
            return false;
        }

        $header = $this->readHeader();
        $allRows = $this->readAll();

        if ($index >= count($allRows)) {
            return false;
        }

        // Remove row at index
        array_splice($allRows, $index, 1);

        // Write back to file
        return $this->writeAllRows($header, $allRows);
    }

    /**
     * Delete all rows (truncate CSV file, keep header only)
     * @return bool True on success, false on failure
     */
    public function deleteAll()
    {
        if (!file_exists($this->filepath)) {
            return false;
        }

        $header = $this->readHeader();
        $file = fopen($this->filepath, 'w');
        if ($file === false) {
            return false;
        }

        $result = fputcsv($file, $header, $this->delimiter, $this->enclosure, '\\');
        fclose($file);

        return $result !== false;
    }

    /**
     * Check if a row matches query criteria
     * @param array $row Row data
     * @param array $header Header row
     * @param array $query Query criteria [column_name => value]
     * @return bool True if row matches all criteria
     */
    private function rowMatchesQuery($row, $header, $query)
    {
        foreach ($query as $columnName => $searchValue) {
            $columnIndex = array_search($columnName, $header, true);
            if ($columnIndex === false) {
                return false; // Column not found
            }

            if (!isset($row[$columnIndex]) || $row[$columnIndex] != $searchValue) {
                return false;
            }
        }

        return true;
    }

    /**
     * Write all rows to CSV file (helper method)
     * @param array $header Header row
     * @param array $rows All data rows
     * @return bool True on success, false on failure
     */
    private function writeAllRows($header, $rows)
    {
        $file = fopen($this->filepath, 'w');
        if ($file === false) {
            return false;
        }

        // Write header
        fputcsv($file, $header, $this->delimiter, $this->enclosure, '\\');

        // Write all rows
        foreach ($rows as $row) {
            fputcsv($file, $row, $this->delimiter, $this->enclosure, '\\');
        }

        fclose($file);
        return true;
    }
}