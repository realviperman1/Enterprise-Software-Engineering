<?php
// @formatter:off
// phpcs:ignoreFile

namespace Illuminate\Database\Migrations {
    class Migration {}
}

namespace Illuminate\Database\Schema {
    class ColumnDefinition {
        public function unique($name = null) { return $this; }
        public function nullable($value = true) { return $this; }
        public function default($value) { return $this; }
        public function index($name = null) { return $this; }
        public function constrained($table = null, $column = 'id') { return $this; }
        public function cascadeOnDelete() { return $this; }
    }
    
    class Blueprint {
        /** @return ColumnDefinition */
        public function id() { return new ColumnDefinition; }
        /** @return ColumnDefinition */
        public function string($column, $length = null) { return new ColumnDefinition; }
        /** @return ColumnDefinition */
        public function json($column) { return new ColumnDefinition; }
        /** @return ColumnDefinition */
        public function enum($column, array $allowed) { return new ColumnDefinition; }
        public function timestamps() {}
        public function softDeletes() {}
        /** @return ColumnDefinition */
        public function foreignId($column) { return new ColumnDefinition; }
        /** @return ColumnDefinition */
        public function dateTime($column, $precision = 0) { return new ColumnDefinition; }
        /** @return ColumnDefinition */
        public function decimal($column, $total = 8, $places = 2) { return new ColumnDefinition; }
    }
}

namespace Illuminate\Support\Facades {
    class Schema {
        public static function create($table, \Closure $callback) {}
        public static function dropIfExists($table) {}
    }
}
