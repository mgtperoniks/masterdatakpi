# Multi KPI Platform Architecture Governance & Session Execution Protocol

## 1. System Overview & Core Philosophy
This workspace contains multiple Laravel KPI applications sharing operational concepts and partially shared infrastructure:
* `masterdatakpi`
* `kpi-bubut`
* `kpi-netto`
* `kpi-lilin`

These systems are NOT independent products. They are operational variants sharing business governance, master resources, and workflow philosophy, while still allowing department-specific operational logic.

IMPORTANT: The software must follow real production workflows. Production reality is the source of truth. Do NOT redesign operational workflows simply for coding convenience. Department-specific operational differences are intentional and valid.

---

## 2. Architectural Principles

### Shared Core (Must Stay Consistent)
The following systems should remain structurally and behaviorally synchronized across projects whenever possible:
* HR Report workflow
* Approval lifecycle
* Audit trail
* Digital signatures
* PDF governance & layouts
* Authentication & user role handling
* Workflow locking rules
* Shared UI governance patterns
* Deployment safety rules

These are considered: **SHARED PLATFORM FEATURES**.

### Department-Specific Logic (Allowed to Diverge)
The following areas MAY differ between projects to reflect real production conditions:
* production formulas
* KPI calculation logic
* process structures
* item/size/process hierarchies
* target methodologies
* downtime workflows
* reject handling
* operational lifecycle details
* dashboard metrics
* machine/process mappings

Examples:
* `kpi-lilin` uses two-level process targets (`item_name` + `size_name`)
* future departments may use 3-level or 4-level production structures

This divergence is intentional. DO NOT force full uniformity.
**Goal:** Maintain governance parity, NOT forced code uniformity.

---

## 3. Source of Truth Mapping

Canonical implementations:

| Module / System            | Source of Truth |
| -------------------------- | --------------- |
| HR Workflow                | `kpi-bubut`     |
| Target Rollover Engine     | `kpi-netto`     |
| Original Base Architecture | `kpi-bubut`     |
| Shared User Data           | `masterdatakpi` |

IMPORTANT: Do NOT automatically assume all future features originate from the same project. Some modules may evolve further in different operational branches.

---

## 4. Target Engine Philosophy
The current standardized target engine philosophy originates from `kpi-netto`. Future KPI applications are expected to follow a similar operational structure with extensible hierarchy support.
Examples:
* `kpi-netto` = single-level process targets
* `kpi-lilin` = two-level process targets
* future systems may implement: 3-level or 4-level structures (process → item → size → variant hierarchies)

The architecture must remain flexible enough to support evolving production structures.
IMPORTANT: Programmers must follow operational production reality, NOT force production to follow rigid software assumptions.

---

## 5. Database & Connection Rules
Production SQL environments are partially interconnected. Some systems share operational resources and master data (e.g. `users`, `operators`, `departments`, `machine references`).

### NEVER assume projects are isolated.
A destructive migration or incorrect synchronization in one project may affect other KPI applications, shared operational visibility, or cross-department data behavior.

---

## 6. Cross-Database Relationship Rules
Cross-database Eloquent relations are preferred over physical database foreign keys.
Examples:
* `submitted_by`
* `approved_by`
* audit references

Users may come from the `master` connection while operational tables remain local in `mysql` connection.

### DO NOT blindly add physical foreign keys.
Prefer Eloquent relations, nullable bigint references, and application-level integrity, NOT database-enforced cross-connection FK constraints.

---

## 7. Migration Philosophy
Preferred migration style is **additive, idempotent, guarded, and backward compatible**.
Preferred patterns:
* `Schema::hasColumn()`
* `Schema::hasTable()`
* Additive enum expansion
* Staged cleanup migrations

Avoid:
* Destructive enum replacement
* Dropping active production columns
* Rollback-dependent workflows
* Dangerous schema rewrites

Migration chains must remain production-safe.

---

## 8. Critical Safety Rules

### NEVER RUN IN PRODUCTION:
```bash
php artisan migrate:fresh
php artisan migrate:fresh --seed
php artisan migrate:rollback
php artisan db:wipe
```

### ALWAYS BACKUP BEFORE MIGRATION:
Before any production migration:
1. backup database
2. verify migration chain
3. verify additive-only behavior
4. verify no destructive operations
5. verify cross-project impact

---

## 9. Synchronization Rules
### DO NOT blindly copy entire projects.
Only synchronize stable shared features, governance workflows, hardened logic, and proven operational flows.
Always preserve branding, production-specific formulas, department-specific operational behavior, hierarchy structures, and existing production data.

---

## 10. UI/UX Governance Philosophy
Workflow behavior should remain visually and operationally consistent across projects whenever possible.
Examples:
* workflow bars
* approval badges
* governance actions
* locking indicators
* PDF layouts
* approval/rejection states
* audit visualization

Branding and color themes MAY differ. Operational workflow behavior should NOT differ unnecessarily.

---

## 11. Session Execution Protocol (Must Follow Every Session)

### Phase 1 — Pre-Implementation Audit
Before any modification:
1. Read this governance document first.
2. Determine:
   * source of truth project
   * shared core vs department-specific logic
   * production impact
   * migration impact
3. Perform:
   * read-only audit first
   * gap analysis
   * risk classification

### Phase 2 — Implementation Safety Guards
BEFORE WRITING:
* show unified diff
* explain business impact
* explain synchronization impact

NEVER:
* overwrite department-specific production logic
* redesign production workflow behavior
* aggressively refactor stable systems

### Phase 3 — Migration Safety Protocol
BEFORE MIGRATION:
* verify backup exists
* verify migration chain
* verify additive-only behavior
* verify no cross-project collision
* verify no destructive schema operation

Production stability is higher priority than schema cleanliness.

### Phase 4 — Post-Implementation Verification
After any implementation:
* verify route integrity
* verify workflow integrity
* verify department isolation
* verify no duplicate creation
* verify no unintended cross-copy behavior
* verify production safety
* verify UI parity where applicable

---

## 12. Priority Ordering
Priority order for all development decisions:
1. **Stability**
2. **Data Integrity**
3. **Production Continuity**
4. **Maintainability**
5. **Governance Parity**
6. **UI/UX Polish**

---

## 13. Long-Term Direction
Long-term architecture direction: **shared platform architecture** (e.g. future extraction of `hr-workflow-core`, `audit-core`, `target-engine-core`, `pdf-core`).
Current priority is operational stability, synchronization, governance consistency, and production-safe evolution, NOT large-scale refactoring.

---

## 14. AI Agent Behavioral Rules
AI agents must prioritize:
* operational safety
* production continuity
* maintainability
* incremental synchronization

AI agents must NOT:
* aggressively refactor stable systems
* redesign workflows without operational justification
* assume all code drift is a bug
* force architectural purity over production practicality

When uncertain:
* perform read-only audit first
* ask for confirmation before destructive or risky actions
* preserve existing production behavior

IMPORTANT: Production stability is more important than elegant code structure.
