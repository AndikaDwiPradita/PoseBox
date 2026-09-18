<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Template Builder · PoseBox</title>
    <link rel="stylesheet" href="{{ asset('_assets/dashboard/custom-template.css') }}">
</head>
<body>

    <!-- ===== SIDEBAR KIRI ===== -->
    <aside class="sidebar-left" id="sidebarLeft">
        <div class="sidebar-header">
            <h1>🧩 Builder</h1>
            <span class="badge">v2.0</span>
        </div>

        <div class="panel-section">
            <label for="templateName">Nama Template</label>
            <input type="text" id="templateName" class="input-field" value="My Template">

            <label for="templateCategory">Kategori</label>
            <input type="text" id="templateCategory" class="input-field" value="General">
        </div>

        <div class="panel-section">
            <label>Jumlah Slot</label>
            <div class="slot-counter">
                <button id="decrementSlot" class="btn-icon">−</button>
                <span id="slotCountDisplay">3</span>
                <button id="incrementSlot" class="btn-icon">+</button>
            </div>
            <div class="slot-actions">
                <button id="addSlotBtn" class="btn btn-primary btn-sm">➕ Tambah</button>
                <button id="removeSlotBtn" class="btn btn-danger btn-sm">➖ Hapus</button>
            </div>
        </div>

        <div class="panel-section">
            <label>Upload Template</label>
            <div class="upload-options">
                <label class="upload-option">
                    <input type="radio" name="uploadMode" value="single" checked> Satu Gambar
                    <small>(background + sticker)</small>
                </label>
                <label class="upload-option">
                    <input type="radio" name="uploadMode" value="dual"> Dua Gambar
                    <small>(background &amp; sticker)</small>
                </label>
            </div>
            <div class="upload-area" id="uploadBackgroundArea">
                <i class="icon">🖼️</i>
                <span>Upload Background</span>
                <input type="file" id="uploadBackground" accept="image/png,image/jpeg">
            </div>
            <div class="upload-area" id="uploadStickerArea" style="display:none;">
                <i class="icon">🏷️</i>
                <span>Upload Sticker</span>
                <input type="file" id="uploadSticker" accept="image/png,image/jpeg">
            </div>
        </div>

        <div class="panel-section">
            <button id="exportJsonBtn" class="btn btn-success btn-block">📥 Export JSON</button>
            <button id="importJsonBtn" class="btn btn-secondary btn-block">📤 Import JSON</button>
            <input type="file" id="importJsonInput" accept=".json" style="display:none;">
            <button id="saveTemplateBtn" class="btn btn-primary btn-block">💾 Simpan Template</button>
        </div>

        <div class="panel-section">
            <div class="keyboard-shortcuts">
                <small><kbd>Ctrl+Z</kbd> Undo</small>
                <small><kbd>Ctrl+Y</kbd> Redo</small>
                <small><kbd>Ctrl+D</kbd> Duplicate</small>
                <small><kbd>Delete</kbd> Hapus</small>
                <small><kbd>←↑↓→</kbd> 1px</small>
                <small><kbd>Shift</kbd>+Arrow = 10px</small>
            </div>
        </div>
    </aside>

    <!-- ===== CANVAS EDITOR ===== -->
    <main class="canvas-wrapper">
        <div class="canvas-toolbar" id="canvasToolbar">
            <button id="undoBtn" class="btn-icon" title="Undo (Ctrl+Z)">↩</button>
            <button id="redoBtn" class="btn-icon" title="Redo (Ctrl+Y)">↪</button>
            <div class="divider"></div>
            <button id="zoomInBtn" class="btn-icon" title="Zoom In">🔍+</button>
            <span id="zoomLevel">100%</span>
            <button id="zoomOutBtn" class="btn-icon" title="Zoom Out">🔍−</button>
            <button id="resetZoomBtn" class="btn-icon" title="Reset Zoom">⟲</button>
            <div class="divider"></div>
            <button id="toggleGridBtn" class="btn-icon" title="Toggle Grid">▦</button>
            <button id="toggleSnapBtn" class="btn-icon" title="Toggle Snap">⊞</button>
            <span id="snapStatus" class="status-badge">Snap OFF</span>
            <div class="divider"></div>
            <span id="slotCountStatus" class="status-badge">0 slot</span>
            <span id="selectedStatus" class="status-badge">-</span>
        </div>

        <div class="canvas-container" id="canvasContainer">
            <div class="canvas-viewport" id="canvasViewport">
                <div class="canvas-stage" id="canvasStage">
                    <div class="canvas-grid" id="canvasGrid"></div>
                    <img id="templateImage" src="" alt="Background">
                    <img id="stickerImage" src="" alt="Sticker" style="display:none;">
                </div>
            </div>
        </div>

        <div class="canvas-status">
            <span id="statusInfo">Ready</span>
        </div>
    </main>

    <!-- ===== SIDEBAR KANAN (PROPERTY PANEL) ===== -->
    <aside class="sidebar-right" id="sidebarRight">
        <div class="panel-header">
            <h2>⚙️ Properties</h2>
            <span id="selectedIdBadge" class="badge">Tidak ada</span>
        </div>

        <div id="propertyPanel">
            <div id="emptyState" class="empty-state">
                <span>📐</span>
                <p>Tidak ada slot dipilih</p>
                <small>Klik salah satu slot untuk mengedit</small>
            </div>

            <div id="propertyForm" style="display:none;">
                <div class="property-group">
                    <label>ID</label>
                    <input type="text" id="propId" readonly class="input-field">
                </div>
                <div class="property-row">
                    <div class="property-group half">
                        <label>Posisi X</label>
                        <input type="number" id="propX" class="input-field input-number" step="1" min="0" value="0">
                    </div>
                    <div class="property-group half">
                        <label>Posisi Y</label>
                        <input type="number" id="propY" class="input-field input-number" step="1" min="0" value="0">
                    </div>
                </div>
                <div class="property-row">
                    <div class="property-group half">
                        <label>Width</label>
                        <input type="number" id="propWidth" class="input-field input-number" step="1" min="20" value="200">
                    </div>
                    <div class="property-group half">
                        <label>Height</label>
                        <input type="number" id="propHeight" class="input-field input-number" step="1" min="20" value="200">
                    </div>
                </div>
                <div class="property-group">
                    <label>Rotation (deg)</label>
                    <div class="range-wrapper">
                        <input type="range" id="propRotation" min="-180" max="180" value="0" step="1">
                        <span id="rotationDisplay">0°</span>
                    </div>
                </div>
                <div class="property-group">
                    <label>Border Radius (%)</label>
                    <div class="range-wrapper">
                        <input type="range" id="propRadius" min="0" max="50" value="0" step="1">
                        <span id="radiusDisplay">0%</span>
                    </div>
                </div>
                <div class="property-group">
                    <label>Opacity (%)</label>
                    <div class="range-wrapper">
                        <input type="range" id="propOpacity" min="10" max="100" value="100" step="1">
                        <span id="opacityDisplay">100%</span>
                    </div>
                </div>
                <div class="property-group">
                    <label>Shape</label>
                    <select id="propShape" class="input-field">
                        <option value="rectangle">Rectangle</option>
                        <option value="rounded">Rounded</option>
                        <option value="circle">Circle</option>
                    </select>
                </div>

                <div class="property-actions">
                    <button id="duplicatePropBtn" class="btn btn-secondary">📋 Duplicate</button>
                    <button id="deletePropBtn" class="btn btn-danger">🗑️ Delete</button>
                </div>

                <div class="preview-area">
                    <label>Preview</label>
                    <div class="slot-preview" id="slotPreview">
                        <div class="preview-placeholder">
                            <span>📷</span>
                            <span>PHOTO</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <script src="{{ asset('_assets/dashboard/custom-template.js') }}"></script>
</body>
</html>
