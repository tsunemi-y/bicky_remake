import React from 'react';
import { Link } from 'react-router-dom';
import './Home.css'; // このCSSファイルは後で作成する

const Home = () => {
  // 特集商品データ（通常はAPIから取得）
  const featuredItems = [
    {
      id: 1,
      title: 'フィーチャー商品1',
      image: '/images/item1.jpg',
      description: 'これは商品1の説明文です。高品質な素材を使用しています。',
      price: '¥3,200'
    },
    {
      id: 2,
      title: 'フィーチャー商品2',
      image: '/images/item2.jpg',
      description: '商品2の特徴をここに説明します。お求めやすい価格です。',
      price: '¥2,800'
    },
    {
      id: 3,
      title: 'フィーチャー商品3',
      image: '/images/item3.jpg',
      description: '商品3は季節限定の商品です。お早めにお買い求めください。',
      price: '¥4,500'
    },
  ];

  return (
    <div className="home-container">
      {/* ヒーローセクション */}
      <section className="hero-section">
        <div className="hero-content">
          <h1>あなたの生活をより豊かに</h1>
          <p>高品質な商品をお手頃価格でお届けします</p>
          <Link to="/products" className="cta-button">
            商品を見る
          </Link>
        </div>
      </section>

      {/* 特集セクション */}
      <section className="featured-section">
        <h2 className="section-title">おすすめ商品</h2>
        <div className="featured-items">
          {featuredItems.map(item => (
            <div key={item.id} className="featured-item">
              <div className="item-image">
                <img src={item.image} alt={item.title} />
              </div>
              <h3>{item.title}</h3>
              <p>{item.description}</p>
              <span className="price">{item.price}</span>
              <Link to={`/products/${item.id}`} className="item-button">
                詳細を見る
              </Link>
            </div>
          ))}
        </div>
      </section>

      {/* CTAセクション */}
      <section className="cta-section">
        <div className="cta-content">
          <h2>今すぐ会員登録して特典をゲット</h2>
          <p>新規会員登録で10%オフクーポンをプレゼント</p>
          <Link to="/register" className="cta-button">
            会員登録する
          </Link>
        </div>
      </section>

      {/* お知らせセクション */}
      <section className="news-section">
        <h2 className="section-title">最新情報</h2>
        <div className="news-items">
          <div className="news-item">
            <span className="news-date">2023.10.15</span>
            <h3>新商品入荷のお知らせ</h3>
            <p>秋冬向けの新商品が入荷しました。ぜひご覧ください。</p>
          </div>
          <div className="news-item">
            <span className="news-date">2023.10.05</span>
            <h3>送料無料キャンペーン実施中</h3>
            <p>10月末まで、5,000円以上のお買い上げで送料無料です。</p>
          </div>
        </div>
      </section>
    </div>
  );
};

export default Home; 