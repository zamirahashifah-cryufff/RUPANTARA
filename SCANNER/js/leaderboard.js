/* ==========================================================================
   RUPANTARA - LEADERBOARD & RANKING PERSISTENCE MODULE
   ========================================================================== */

class RupantaraLeaderboard {
  constructor() {
    this.storageKey = "rupantara_leaderboard_scores";
    this.scores = this.loadScores();
  }

  // Initial Seed Data if LocalStorage is Empty
  loadScores() {
    const data = localStorage.getItem(this.storageKey);
    if (data) {
      try {
        return JSON.parse(data);
      } catch (e) {
        console.warn('Gagal membaca LocalStorage leaderboard, menggunakan seed data.');
      }
    }

    const defaultSeed = [
      { id: 1, name: "Andi Pratama", score: 950, completed: 3, date: "2026-08-10" },
      { id: 2, name: "Sinta Maharani", score: 900, completed: 2, date: "2026-08-11" },
      { id: 3, name: "Budi Santoso", score: 850, completed: 4, date: "2026-08-09" },
      { id: 4, name: "Rizky Ramadhan", score: 800, completed: 2, date: "2026-08-11" },
      { id: 5, name: "Maya Indah", score: 750, completed: 1, date: "2026-08-08" }
    ];

    localStorage.setItem(this.storageKey, JSON.stringify(defaultSeed));
    return defaultSeed;
  }

  saveScores() {
    localStorage.setItem(this.storageKey, JSON.stringify(this.scores));
  }

  addScore(playerName, newScore) {
    const existingPlayer = this.scores.find(s => s.name.toLowerCase() === playerName.toLowerCase());
    if (existingPlayer) {
      if (newScore > existingPlayer.score) {
        existingPlayer.score = newScore;
      }
      existingPlayer.completed += 1;
    } else {
      this.scores.push({
        id: Date.now(),
        name: playerName,
        score: newScore,
        completed: 1,
        date: new Date().toISOString().split('T')[0]
      });
    }

    // Sort descending by score
    this.scores.sort((a, b) => b.score - a.score);
    this.saveScores();
    this.render();
  }

  render() {
    const podiumWrapper = document.getElementById('podiumWrapper');
    const tableBody = document.getElementById('leaderboardTableBody');

    if (!podiumWrapper || !tableBody) return;

    podiumWrapper.innerHTML = '';
    tableBody.innerHTML = '';

    const top3 = this.scores.slice(0, 3);
    const rest = this.scores.slice(3);

    // 1. Render Top 3 Podium
    const ranks = ['rank-1', 'rank-2', 'rank-3'];
    const crowns = ['🥇', '🥈', '🥉'];

    top3.forEach((item, index) => {
      const podiumCard = document.createElement('div');
      podiumCard.className = `podium-card ${ranks[index]}`;
      podiumCard.innerHTML = `
        <div class="podium-crown">${crowns[index]}</div>
        <div class="podium-name">${item.name}</div>
        <div class="podium-score">${item.score} Pts</div>
        <span style="font-size:0.75rem; color:var(--slate-500); margin-top:0.3rem;">${item.completed}x Kuis</span>
      `;
      podiumWrapper.appendChild(podiumCard);
    });

    // 2. Render Remaining Table Ranks
    if (this.scores.length === 0) {
      tableBody.innerHTML = '<tr><td colspan="4" style="text-align:center;">Belum ada data skor.</td></tr>';
      return;
    }

    this.scores.forEach((item, index) => {
      const tr = document.createElement('tr');
      let medalBadge = `#${index + 1}`;
      if (index === 0) medalBadge = '🥇 #1';
      else if (index === 1) medalBadge = '🥈 #2';
      else if (index === 2) medalBadge = '🥉 #3';

      tr.innerHTML = `
        <td><strong>${medalBadge}</strong></td>
        <td><strong>${item.name}</strong></td>
        <td><span class="text-primary" style="font-weight:800;">${item.score}</span> Pts</td>
        <td>${item.completed} Selesai</td>
      `;
      tableBody.appendChild(tr);
    });
  }
}

document.addEventListener('DOMContentLoaded', () => {
  window.rupantaraLeaderboard = new RupantaraLeaderboard();
  window.rupantaraLeaderboard.render();
});
